<?php

namespace App\ParserBundle\Domain;

class ShoprenterWorker
{
    private int $id;
    private string $firstName;
    private string $lastName;

    public function __construct(int $id, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

}