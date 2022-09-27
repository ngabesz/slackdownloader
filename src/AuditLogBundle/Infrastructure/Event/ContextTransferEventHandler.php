<?php

namespace App\AuditLogBundle\Infrastructure\Event;

use App\AuditLogBundle\Application\LogUserEvent\LogUserEventCommand;
use App\Shared\Infrastructure\Event\ContextTransferEvent;
use Exception;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

use function array_key_exists;

class ContextTransferEventHandler
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function __invoke(ContextTransferEvent $event): void
    {
        $data = $event->getData();

        if (!array_key_exists('userId', $data)) {
            throw new Exception('ContextTransferEventHandler | Required data is missing: userId');
        }

        $this->handle(new LogUserEventCommand(
            $data['userId'],
            $event->getEventName(),
            $event->getHappenedAt()
        ));
    }

}
