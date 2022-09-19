<?php

namespace App\RemoteUserBundle\Application\GetUserById;

use App\RemoteUserBundle\Application\Exception\UserNotFoundException;
use App\RemoteUserBundle\Domain\UserRepositoryInterface;

class GetUserByIdHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetUserByIdQuery $query)
    {
        $userId = $query->getId();

        $user = $this->repository->getUserById($userId);

        if (!$user) {
            throw new UserNotFoundException($userId);
        }

        return $user;
    }
}