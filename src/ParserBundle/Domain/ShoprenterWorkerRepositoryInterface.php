<?php

namespace App\ParserBundle\Domain;

use App\ParserBundle\Domain\Exception\DomainException;

interface ShoprenterWorkerRepositoryInterface
{
    /**
     * @throws DomainException
     */
    public function authenticate(string $username, string $password): ShoprenterWorker;

    /**
     * @throws DomainException
     */
    public function getById(int $id): ShoprenterWorker;
}