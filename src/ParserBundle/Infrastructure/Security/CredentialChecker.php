<?php

namespace App\ParserBundle\Infrastructure\Security;

use App\ParserBundle\Application\AuthenticateShoprenterWorker\AuthenticateShoprenterWorkerQuery;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CredentialChecker
{
    private MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        try {
            $this->queryBus->dispatch(new AuthenticateShoprenterWorkerQuery(
                $credentials['username'],
                $credentials['password']
            ));
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}