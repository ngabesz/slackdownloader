<?php

namespace App\Presentation\Cli\Symfony;

use App\Application\GetImagesFromFile\GetImagesFromFileHandler;
use App\Application\GetImagesFromFile\GetImagesFromFileQuery;
use App\Domain\MemeImage;
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

    public function __construct(GetImagesFromFileHandler $getImagesFromFileHandler)
    {
        parent::__construct();
        $this->getImagesFromFileHandler = $getImagesFromFileHandler;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filePath', InputArgument::REQUIRED, 'File path what is relative to command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $filePath = $input->getArgument('filePath');

        $urls = $this->getImagesFromFileHandler->execute(new GetImagesFromFileQuery(
            $filePath,
            'uploadedFile_' . time() . '.json'
        ));

        /** @var MemeImage $url */
        foreach ($urls as $url) {
            $io->writeln($url->getUrl());
        }

        return Command::SUCCESS;
    }
}
