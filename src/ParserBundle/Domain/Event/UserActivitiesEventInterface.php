<?php

namespace App\ParserBundle\Domain\Event;

interface UserActivitiesEventInterface
{
    public function getUserId(): int;
}
