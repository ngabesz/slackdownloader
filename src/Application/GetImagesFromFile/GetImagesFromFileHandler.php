<?php

namespace App\Application\GetImagesFromFile;

use App\Domain\ValueObject\InputFile;
use App\Domain\MemeImageCollection;
use App\Domain\MemeImageParserInterface;

class GetImagesFromFileHandler
{
    private MemeImageParserInterface $parser;

    public function __construct(MemeImageParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function execute(GetImagesFromFileQuery $query): MemeImageCollection
    {
        return $this->parser->getMemeImagesFromFile(new InputFile(
            $query->getFilePath(),
            $query->getFileName()
        ));
    }
}