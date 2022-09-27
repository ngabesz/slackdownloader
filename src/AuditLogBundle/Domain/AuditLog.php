<?php

namespace App\AuditLogBundle\Domain;

use DateTimeImmutable;

class AuditLog
{
    private int $id;
    private int $userId;
    private string $eventName;
    private DateTimeImmutable $happenedAt;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
    }

    public function setHappenedAt(DateTimeImmutable $happenedAt): void
    {
        $this->happenedAt = $happenedAt;
    }
}
