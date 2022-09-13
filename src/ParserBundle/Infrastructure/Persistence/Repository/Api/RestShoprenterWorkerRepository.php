<?php

namespace App\ParserBundle\Infrastructure\Persistence\Repository\Api;

use App\ParserBundle\Domain\Exception\DomainException;
use App\ParserBundle\Domain\ShoprenterWorker;
use App\ParserBundle\Domain\ShoprenterWorkerRepositoryInterface;
use App\ParserBundle\Infrastructure\Shared\Client\RemoteUserClient;
use Exception;

class RestShoprenterWorkerRepository implements ShoprenterWorkerRepositoryInterface
{
    private RemoteUserClient $client;

    public function __construct(RemoteUserClient $client)
    {
        $this->client = $client;
    }

    public function getByCredentials(string $username, string $password): ShoprenterWorker
    {
        try {
            $response = $this->client->authenticate($username, $password);
        } catch (Exception $e) {
            throw new DomainException('Shoprenter worker is not found: ' . $username);
        }

        return new ShoprenterWorker(
            $response['id'],
            $response['firstName'],
            $response['lastName']
        );
    }
}