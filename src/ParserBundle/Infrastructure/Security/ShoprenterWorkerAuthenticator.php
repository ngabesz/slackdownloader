<?php


namespace App\ParserBundle\Infrastructure\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\PasswordUpgradeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\ParameterBagUtils;

class ShoprenterWorkerAuthenticator extends AbstractLoginFormAuthenticator
{
  private $httpUtils;
  private $userProvider;

  private $options;
  private $httpKernel;
  private $credentialChecker;

  public function __construct(HttpUtils $httpUtils, UserProviderInterface $userProvider,  CredentialChecker $credentialChecker)
  {
    $this->httpUtils = $httpUtils;
    $this->userProvider = $userProvider;
    $this->credentialChecker = $credentialChecker;
    $this->options = [
        'username_parameter' => '_username',
        'password_parameter' => '_password',
        'check_path' => '/login',
        'login_path' => '/login',
        'post_only' => true,
        'form_only' => false,
        'use_forward' => false,
        'enable_csrf' => false,
        'csrf_parameter' => '_csrf_token',
        'csrf_token_id' => 'authenticate',
    ];
  }

  protected function getLoginUrl(Request $request): string
  {
    return $this->httpUtils->generateUri($request, $this->options['login_path']);
  }

  public function supports(Request $request): bool
  {
    return ($this->options['post_only'] ? $request->isMethod('POST') : true)
        && $this->httpUtils->checkRequestPath($request, $this->options['check_path'])
        && ($this->options['form_only'] ? 'form' === $request->getContentType() : true);
  }

  public function authenticate(Request $request): Passport
  {
    $credentials = $this->getCredentials($request);

    // @deprecated since Symfony 5.3, change to $this->userProvider->loadUserByIdentifier() in 6.0
    $method = 'loadUserByIdentifier';
    if (!method_exists($this->userProvider, 'loadUserByIdentifier')) {
      trigger_deprecation('symfony/security-core', '5.3', 'Not implementing method "loadUserByIdentifier()" in user provider "%s" is deprecated. This method will replace "loadUserByUsername()" in Symfony 6.0.', get_debug_type($this->userProvider));

      $method = 'loadUserByUsername';
    }

    return new Passport(
        new UserBadge($credentials['username'], [$this->userProvider, $method]),
        new CustomCredentials([$this->credentialChecker, 'checkCredentials'],$credentials),
    );

  }

  /**
   * @deprecated since Symfony 5.4, use {@link createToken()} instead
   */
  public function createAuthenticatedToken(PassportInterface $passport, string $firewallName): TokenInterface
  {
    trigger_deprecation('symfony/security-http', '5.4', 'Method "%s()" is deprecated, use "%s::createToken()" instead.', __METHOD__, __CLASS__);

    return $this->createToken($passport, $firewallName);
  }

  public function createToken(Passport $passport, string $firewallName): TokenInterface
  {
    return new UsernamePasswordToken($passport->getUser(), $firewallName, $passport->getUser()->getRoles());
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
  {
    return $this->httpUtils->createRedirectResponse($request,'/file/upload');
  }

  public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
  {
    return $this->httpUtils->createRedirectResponse($request,'/login');
  }

  private function getCredentials(Request $request): array
  {
    $credentials = [];
    $credentials['csrf_token'] = ParameterBagUtils::getRequestParameterValue($request, $this->options['csrf_parameter']);

    if ($this->options['post_only']) {
      $credentials['username'] = ParameterBagUtils::getParameterBagValue($request->request, $this->options['username_parameter']);
      $credentials['password'] = ParameterBagUtils::getParameterBagValue($request->request, $this->options['password_parameter']) ?? '';
    } else {
      $credentials['username'] = ParameterBagUtils::getRequestParameterValue($request, $this->options['username_parameter']);
      $credentials['password'] = ParameterBagUtils::getRequestParameterValue($request, $this->options['password_parameter']) ?? '';
    }

    if (!\is_string($credentials['username']) && (!\is_object($credentials['username']) || !method_exists($credentials['username'], '__toString'))) {
      throw new BadRequestHttpException(sprintf('The key "%s" must be a string, "%s" given.', $this->options['username_parameter'], \gettype($credentials['username'])));
    }

    $credentials['username'] = trim($credentials['username']);

    if (\strlen($credentials['username']) > Security::MAX_USERNAME_LENGTH) {
      throw new BadCredentialsException('Invalid username.');
    }

    $request->getSession()->set(Security::LAST_USERNAME, $credentials['username']);

    return $credentials;
  }

  public function setHttpKernel(HttpKernelInterface $httpKernel): void
  {
    $this->httpKernel = $httpKernel;
  }

  public function start(Request $request, AuthenticationException $authException = null): Response
  {
    if (!$this->options['use_forward']) {
      return parent::start($request, $authException);
    }

    $subRequest = $this->httpUtils->createRequest($request, $this->options['login_path']);
    $response = $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    if (200 === $response->getStatusCode()) {
      $response->setStatusCode(401);
    }

    return $response;
  }
}