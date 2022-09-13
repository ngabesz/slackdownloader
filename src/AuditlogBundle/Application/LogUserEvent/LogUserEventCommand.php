<?php

namespace App\AuditlogBundle\Application\LogUserEvent;

use DateTimeImmutable;

class LogUserEventCommand
{
    private int $userId;
    private string $eventName;
    private DateTimeImmutable $happenedAt;

    public function __construct(int $userId, string $eventName, DateTimeImmutable $happenedAt)
    {
        $this->userId = $userId;
        $this->eventName = $eventName;
        $this->happenedAt = $happenedAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getHappenedAt(): DateTimeImmutable
    {
        return $this->happenedAt;
    }
}
