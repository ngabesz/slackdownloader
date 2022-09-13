<?php

namespace App\AuditlogBundle\Domain;

interface AuditLogRepositoryInterface
{
    public function save(Auditlog $auditLog): void;
}
