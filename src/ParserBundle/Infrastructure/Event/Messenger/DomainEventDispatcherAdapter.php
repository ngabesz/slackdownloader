<?php

namespace App\ParserBundle\Infrastructure\Event\Messenger;

use App\ParserBundle\Domain\Event\DomainEventDispatcherInterface;
use App\ParserBundle\Domain\Event\UserActivitiesEventInterface;
use App\Shared\Infrastructure\Event\ContextTransferEvent;
use Symfony\Component\Messenger\MessageBusInterface;

use function get_class;

class DomainEventDispatcherAdapter implements DomainEventDispatcherInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->bus = $eventBus;
    }

    public function dispatchUserActivityEvent(UserActivitiesEventInterface $event): void
    {
        $this->bus->dispatch(new ContextTransferEvent(
            get_class($event),
            $event->getHappenedAt(),
            [
                'userId' => $event->getUserId()
            ]
        ));
    }
}