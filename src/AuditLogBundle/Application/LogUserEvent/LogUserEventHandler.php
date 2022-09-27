<?php

namespace App\AuditLogBundle\Application\LogUserEvent;

use App\AuditLogBundle\Domain\AuditLog;
use App\AuditLogBundle\Domain\AuditLogRepositoryInterface;

class LogUserEventHandler
{
    private AuditLogRepositoryInterface $repository;

    public function __construct(AuditLogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(LogUserEventCommand $command): void
    {
        $newLog = new AuditLog();
        $newLog->setEventName($command->getEventName());
        $newLog->setUserId($command->getUserId());
        $newLog->setHappenedAt($command->getHappenedAt());

        $this->repository->save($newLog);
    }
}