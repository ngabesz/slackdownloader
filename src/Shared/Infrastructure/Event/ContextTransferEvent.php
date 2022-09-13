<?php

namespace App\Shared\Infrastructure\Event;

use DateTimeImmutable;

class ContextTransferEvent
{
    private string $eventName;
    private DateTimeImmutable $happenedAt;
    private array $data;

    public function __construct(
        string $eventName,
        DateTimeImmutable $happenedAt,
        array $data = []
    ) {
        $this->eventName = $eventName;
        $this->happenedAt = $happenedAt;
        $this->data = $data;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getHappenedAt(): DateTimeImmutable
    {
        return $this->happenedAt;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
