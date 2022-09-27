<?php

namespace App\RemoteUserBundle\Infrastructure\Event\Messenger;

use App\RemoteUserBundle\Domain\Event\DomainEventDispatcherInterface;
use App\RemoteUserBundle\Domain\Event\UserActivityEventInterface;
use App\Shared\Infrastructure\Event\ContextTransferEvent;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

use function get_class;

class DomainEventDispatcherAdapter implements DomainEventDispatcherInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->messageBus = $eventBus;
    }

    public function dispatchUserActivityEvent(UserActivityEventInterface $event): void
    {
        $this->handle(new ContextTransferEvent(
            get_class($event),
            $event->getHappenedAt(),
            [
                'userId' => $event->getUserId()
            ]
        ));
    }
}