<?php

namespace App\RemoteUserBundle\Domain\Event;

interface UserActivityEventInterface
{
    public function getUserId(): int;
}
