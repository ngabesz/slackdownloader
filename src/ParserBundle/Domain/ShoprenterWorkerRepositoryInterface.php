<?php

namespace App\ParserBundle\Domain;

use App\ParserBundle\Domain\Exception\DomainException;

interface ShoprenterWorkerRepositoryInterface
{
    /**
     * @throws DomainException
     */
    public function getByCredentials(string $username, string $password): ShoprenterWorker;
}