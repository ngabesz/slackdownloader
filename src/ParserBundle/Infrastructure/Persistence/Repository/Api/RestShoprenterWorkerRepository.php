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

    public function authenticate(string $username, string $password): ShoprenterWorker
    {
        try {
            $response = $this->client->authenticate($username, $password);
        } catch (Exception $e) {
            throw new DomainException($e->getMessage());
        }

        return new ShoprenterWorker(
            $response['id'],
            $response['firstName'],
            $response['lastName']
        );
    }

    public function getById(int $id): ShoprenterWorker
    {
        try {
            $response = $this->client->getWorkerById($id);
        } catch (Exception $e) {
            throw new DomainException('Shoprenter worker is not found with id: ' . $id);
        }

        return new ShoprenterWorker(
            $response['id'],
            $response['firstName'],
            $response['lastName']
        );
    }
}