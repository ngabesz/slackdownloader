<?php

namespace App\ParserBundle\Infrastructure\Security;

use App\ParserBundle\Application\AuthenticateShoprenterWorker\AuthenticateShoprenterWorkerHandler;
use App\ParserBundle\Application\AuthenticateShoprenterWorker\AuthenticateShoprenterWorkerQuery;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;

class CredentialChecker
{
    private AuthenticateShoprenterWorkerHandler $handler;

    public function __construct(AuthenticateShoprenterWorkerHandler $handler)
    {
        $this->handler = $handler;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        try {
            $this->handler->execute(new AuthenticateShoprenterWorkerQuery(
                $credentials['username'],
                $credentials['password']
            ));
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}