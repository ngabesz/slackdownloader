<?php

namespace App\RemoteUserBundle\Domain;

interface UserRepositoryInterface
{
    public function getUserByCredentials(string $email, string $password): User;
    public function getUserByEmail(string $email): User;
}