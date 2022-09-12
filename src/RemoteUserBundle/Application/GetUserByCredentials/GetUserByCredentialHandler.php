<?php

namespace App\RemoteUserBundle\Application\GetUserByCredentials;

use App\RemoteUserBundle\Domain\User;
use App\RemoteUserBundle\Domain\UserNotFoundException;
use App\RemoteUserBundle\Domain\UserRepositoryInterface;

class GetUserByCredentialHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(GetUserByCredentialQuery $query): User
    {
        $user = $this->userRepository->getUserByCredentials($query->getUserName(), $query->getPassword());

        if (!$user){
          throw new UserNotFoundException();
        }

        return $user;
    }
}