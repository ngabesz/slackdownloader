<?php

namespace App\AuditLogBundle\Infrastructure\Persistence\Doctrine\Repository;

use App\AuditLogBundle\Domain\AuditLog;
use App\AuditLogBundle\Domain\AuditLogRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuditLogRepository extends ServiceEntityRepository implements AuditLogRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditLog::class);
    }

    public function save(AuditLog $auditLog): void
    {
        $this->_em->persist($auditLog);
        $this->_em->flush();
    }
}
