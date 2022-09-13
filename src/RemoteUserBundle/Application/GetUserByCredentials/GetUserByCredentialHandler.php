<?php

namespace App\RemoteUserBundle\Application\GetUserByCredentials;

use App\RemoteUserBundle\Application\Exception\UserNotFoundException;
use App\RemoteUserBundle\Domain\Event\DomainEventDispatcherInterface;
use App\RemoteUserBundle\Domain\Event\UserLoggedInEvent;
use App\RemoteUserBundle\Domain\User;
use App\RemoteUserBundle\Domain\UserRepositoryInterface;
use DateTimeImmutable;

class GetUserByCredentialHandler
{
    private UserRepositoryInterface $userRepository;
    private DomainEventDispatcherInterface $dispatcher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        DomainEventDispatcherInterface $dispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->dispatcher = $dispatcher;
    }

    public function execute(GetUserByCredentialQuery $query): User
    {
        $user = $this->userRepository->getUserByCredentials($query->getUserName(), $query->getPassword());

        if (!$user){
          throw new UserNotFoundException($query->getUserName());
        }

        $this->dispatcher->dispatchUserActivityEvent(new UserLoggedInEvent(
            $user->getId(),
            new DateTimeImmutable()
        ));

        return $user;
    }
}