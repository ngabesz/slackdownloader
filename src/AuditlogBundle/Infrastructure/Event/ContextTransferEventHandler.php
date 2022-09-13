<?php

namespace App\AuditlogBundle\Infrastructure\Event;

use App\AuditlogBundle\Application\LogUserEvent\LogUserEventCommand;
use App\AuditlogBundle\Application\LogUserEvent\LogUserEventHandler;
use App\Shared\Infrastructure\Event\ContextTransferEvent;
use Exception;

use function array_key_exists;

class ContextTransferEventHandler
{
    private LogUserEventHandler $handler;

    public function __construct(LogUserEventHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(ContextTransferEvent $event): void
    {
        $data = $event->getData();

        if (!array_key_exists('userId', $data)) {
            throw new Exception('ContextTransferEventHandler | Required data is missing: userId');
        }

        $this->handler->execute(new LogUserEventCommand(
            $data['userId'],
            $event->getEventName(),
            $event->getHappenedAt()
        ));
    }

}
