<?php

namespace App\ParserBundle\Domain\Event;

interface DomainEventDispatcherInterface
{
    public function dispatchUserActivityEvent(UserActivitiesEventInterface $event): void;
}
