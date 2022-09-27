<?php

namespace App\AuditLogBundle\Domain;

interface AuditLogRepositoryInterface
{
    public function save(AuditLog $auditLog): void;
}
