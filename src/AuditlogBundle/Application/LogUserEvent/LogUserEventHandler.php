<?php

namespace App\AuditlogBundle\Application\LogUserEvent;

use App\AuditlogBundle\Domain\Auditlog;
use App\AuditlogBundle\Domain\AuditLogRepositoryInterface;

class LogUserEventHandler
{
    private AuditLogRepositoryInterface $repository;

    public function __construct(AuditLogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(LogUserEventCommand $command): void
    {
        $newLog = new Auditlog();
        $newLog->setEventName($command->getEventName());
        $newLog->setUserId($command->getUserId());
        $newLog->setHappenedAt($command->getHappenedAt());

        $this->repository->save($newLog);
    }
}