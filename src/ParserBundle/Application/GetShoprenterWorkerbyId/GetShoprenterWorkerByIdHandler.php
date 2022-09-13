<?php

namespace App\ParserBundle\Application\GetShoprenterWorkerbyId;

use App\ParserBundle\Application\Exception\ApplicationException;
use App\ParserBundle\Domain\Exception\DomainException;
use App\ParserBundle\Domain\ShoprenterWorker;
use App\ParserBundle\Domain\ShoprenterWorkerRepositoryInterface;

class GetShoprenterWorkerByIdHandler
{
    private ShoprenterWorkerRepositoryInterface $workerRepository;

    public function __construct(ShoprenterWorkerRepositoryInterface $workerRepository)
    {
        $this->workerRepository = $workerRepository;
    }

    public function execute(GetShoprenterWorkerByIdQuery $query): ShoprenterWorker
    {
        try {
            return $this->workerRepository->getById($query->getId());
        } catch (DomainException $e) {
            throw new ApplicationException($e->getMessage(), $e->getCode());
        }
    }
}