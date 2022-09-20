<?php

namespace App\ParserBundle\Application\GetImagesFromFile;

use App\ParserBundle\Application\Exception\ApplicationException;
use App\ParserBundle\Domain\Event\DomainEventDispatcherInterface;
use App\ParserBundle\Domain\Event\UserParsedImagesEvent;
use App\ParserBundle\Domain\Exception\DomainException;
use App\ParserBundle\Domain\MemeImageCollection;
use App\ParserBundle\Domain\ShoprenterWorkerRepositoryInterface;
use App\ParserBundle\Domain\ValueObject\InputFile;
use App\ParserBundle\Domain\MemeImageParserInterface;
use DateTimeImmutable;

class GetImagesFromFileHandler
{
    private MemeImageParserInterface $parser;
    private DomainEventDispatcherInterface $dispatcher;
    private ShoprenterWorkerRepositoryInterface $workerRepository;

    public function __construct(
        MemeImageParserInterface $parser,
        DomainEventDispatcherInterface $dispatcher,
        ShoprenterWorkerRepositoryInterface $workerRepository
    ) {
        $this->parser = $parser;
        $this->dispatcher = $dispatcher;
        $this->workerRepository = $workerRepository;
    }

    /**
     * @throws ApplicationException
     */
    public function __invoke(GetImagesFromFileQuery $query): MemeImageCollection
    {
        $worker = $this->workerRepository->getById($query->getWorkerId());

        try {
            $collection = $this->parser->getMemeImagesFromFile(new InputFile(
                $query->getFilePath(),
                $query->getFileName()
            ));
        } catch (DomainException $e) {
            throw new ApplicationException($e->getMessage(), $e->getCode());
        }

        $this->dispatcher->dispatchUserActivityEvent(new UserParsedImagesEvent(
            $worker->getId(),
            new DateTimeImmutable(),
        ));

        return $collection;
    }
}