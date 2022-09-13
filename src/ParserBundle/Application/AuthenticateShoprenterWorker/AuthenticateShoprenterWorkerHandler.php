<?php

namespace App\ParserBundle\Application\AuthenticateShoprenterWorker;

use App\ParserBundle\Application\Exception\ApplicationException;
use App\ParserBundle\Domain\Exception\DomainException;
use App\ParserBundle\Domain\ShoprenterWorker;
use App\ParserBundle\Domain\ShoprenterWorkerRepositoryInterface;

class AuthenticateShoprenterWorkerHandler
{
    private ShoprenterWorkerRepositoryInterface $workerRepository;

    public function __construct(ShoprenterWorkerRepositoryInterface $workerRepository)
    {
        $this->workerRepository = $workerRepository;
    }

    public function execute(AuthenticateShoprenterWorkerQuery $query): ShoprenterWorker
    {
        try {
            return $this->workerRepository->authenticate(
                $query->getUsername(),
                $query->getPassword()
            );
        } catch (DomainException $e) {
            throw new ApplicationException($e->getMessage(), $e->getCode());
        }
    }
}