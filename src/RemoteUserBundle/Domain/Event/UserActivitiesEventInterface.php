<?php

namespace App\RemoteUserBundle\Domain\Event;

interface UserActivitiesEventInterface
{
    public function getUserId(): int;
}
