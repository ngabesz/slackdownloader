<?php

namespace App\RemoteUserBundle\Application\GetUserByEmail;

use App\RemoteUserBundle\Domain\User;
use App\RemoteUserBundle\Domain\UserRepositoryInterface;

class GetUserByEmailHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(GetUserByEmailQuery $query): User
    {
        return $this->userRepository->getUserByEmail($query->getEmail());
    }
}