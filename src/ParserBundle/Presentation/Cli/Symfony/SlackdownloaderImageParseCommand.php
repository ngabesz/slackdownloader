<?php

namespace App\ParserBundle\Presentation\Cli\Symfony;

use App\ParserBundle\Application\AuthenticateShoprenterWorker\AuthenticateShoprenterWorkerHandler;
use App\ParserBundle\Application\AuthenticateShoprenterWorker\AuthenticateShoprenterWorkerQuery;
use App\ParserBundle\Application\Exception\ApplicationException;
use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileHandler;
use App\ParserBundle\Application\GetImagesFromFile\GetImagesFromFileQuery;
use App\ParserBundle\Domain\MemeImage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function time;


class SlackdownloaderImageParseCommand extends Command
{
    protected static $defaultName = 'slackdownloader:image:parse';
    protected static $defaultDescription = 'It parsing urls form slack file';

    private GetImagesFromFileHandler $getImagesFromFileHandler;
    private AuthenticateShoprenterWorkerHandler $authenticateShoprenterWorkerHandler;

    public function __construct(
        GetImagesFromFileHandler $getImagesFromFileHandler,
        AuthenticateShoprenterWorkerHandler $authenticateShoprenterWorkerHandler
    ) {
        parent::__construct();
        $this->getImagesFromFileHandler = $getImagesFromFileHandler;
        $this->authenticateShoprenterWorkerHandler = $authenticateShoprenterWorkerHandler;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
            ->addArgument('filePath', InputArgument::REQUIRED, 'File path what is relative to command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $filePath = $input->getArgument('filePath');

        try {
            $worker = $this->authenticateShoprenterWorkerHandler->execute(new AuthenticateShoprenterWorkerQuery(
                $input->getArgument('username'),
                $input->getArgument('password')
            ));
        } catch (ApplicationException $e) {
            $io->error('Access Denied! ' . $e->getMessage());
            return Command::FAILURE;
        }

        $urls = $this->getImagesFromFileHandler->execute(new GetImagesFromFileQuery(
            $filePath,
            'uploadedFile_' . time() . '.json',
            $worker->getId()
        ));

        /** @var MemeImage $url */
        foreach ($urls as $url) {
            $io->writeln($url->getUrl());
        }

        return Command::SUCCESS;
    }
}
