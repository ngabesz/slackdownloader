<?php

namespace App\RemoteUserBundle\Domain\Event;

interface DomainEventDispatcherInterface
{
    public function dispatchUserActivityEvent(UserActivitiesEventInterface $event): void;
}
