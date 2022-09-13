<?php

namespace App\ParserBundle\Domain\Event;

use DateTimeImmutable;

class UserParsedImagesEvent extends DomainEvent implements UserActivitiesEventInterface
{
    private int $userId;

    public function __construct(int $userId, DateTimeImmutable $happenedAt)
    {
        $this->userId = $userId;
        $this->happenedAt = $happenedAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
