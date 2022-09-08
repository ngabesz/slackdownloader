<?php

namespace App\RemoteUserBundle\Infrastructure\Persistence\Doctrine\Repository;

use App\RemoteUserBundle\Domain\User;
use App\RemoteUserBundle\Domain\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserByCredentials(string $email, string $password): User
    {
        return $this->findOneBy([
           'email' => $email,
           'password' => $password
        ]);
    }

    public function getUserByEmail(string $email): User
    {
        return $this->findOneBy([
            'email' => $email
        ]);
    }
}