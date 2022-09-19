<?php

namespace App\RemoteUserBundle\Presentation\Api\Rest;

use App\RemoteUserBundle\Application\Exception\UserNotFoundException;
use App\RemoteUserBundle\Application\GetUserByCredentials\GetUserByCredentialsHandler;
use App\RemoteUserBundle\Application\GetUserByCredentials\GetUserByCredentialsQuery;
use App\RemoteUserBundle\Application\GetUserByEmail\GetUserByEmailHandler;
use App\RemoteUserBundle\Application\GetUserByEmail\GetUserByEmailQuery;
use App\RemoteUserBundle\Application\GetUserById\GetUserByIdHandler;
use App\RemoteUserBundle\Application\GetUserById\GetUserByIdQuery;
use App\RemoteUserBundle\Domain\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class UserApiController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function getByEmailAction(Request $request)
    {

        $email = $request->get('email');

        try {
            /** @var User $user */
            $user = $this->handle(new GetUserByEmailQuery($email));
        } catch (UserNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], 404);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'password' => $user->getPassword()
        ], 200);
    }

    public function authAction(Request $request)
    {

        $email = $request->get('email');
        $password = $request->get('password');

        try {
            /** @var User $user */
            $user = $this->handle(new GetUserByCredentialsQuery(
                $email,
                $password
            ));
        } catch (UserNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], 404);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName()
        ], 200);
    }

    public function getByIdAction(int $userId)
    {

        try {
            /** @var User $user */
            $user = $this->handle(new GetUserByIdQuery($userId));
        } catch (UserNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'password' => $user->getPassword()
        ], 200);
    }

}