<?php

namespace App\AuditlogBundle\Infrastructure\Persistence\Doctrine\Repository;

use App\AuditlogBundle\Domain\Auditlog;
use App\AuditlogBundle\Domain\AuditLogRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuditlogRepository extends ServiceEntityRepository implements AuditLogRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auditlog::class);
    }

    public function save(Auditlog $auditLog): void
    {
        $this->_em->persist($auditLog);
        $this->_em->flush();
    }
}