<?php

namespace App\RemoteUserBundle\Application\GetUserById;

use App\ParserBundle\Application\Exception\ApplicationException;
use App\RemoteUserBundle\Application\Exception\UserNotFoundException;
use App\RemoteUserBundle\Domain\User;
use App\RemoteUserBundle\Domain\UserRepositoryInterface;

class GetUserByIdHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetUserByIdQuery $query): User
    {
        $userId = $query->getId();

        $user = $this->repository->getUserById($userId);

        if (!$user) {
            throw new UserNotFoundException($userId);
        }

        return $user;
    }
}