<?php

namespace App\ParserBundle\Domain\Event;

use DateTimeImmutable;

abstract class DomainEvent
{
    protected DateTimeImmutable $happenedAt;

    public function getHappenedAt(): DateTimeImmutable
    {
        return $this->happenedAt;
    }
}
