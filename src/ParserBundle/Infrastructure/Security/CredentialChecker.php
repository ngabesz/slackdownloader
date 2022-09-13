<?php

namespace App\ParserBundle\Infrastructure\Security;

use App\ParserBundle\Infrastructure\Shared\Client\RemoteUserClient;
use Symfony\Component\Security\Core\User\UserInterface;

class CredentialChecker
{

    protected RemoteUserClient $client;

    public function __construct(RemoteUserClient $client)
    {
        $this->client = $client;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        try {
            $this->client->authenticate($credentials['username'], $credentials['password']);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}