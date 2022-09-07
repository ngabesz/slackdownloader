<?php

namespace App\ParserBundle\Application\GetImagesFromFile;

use App\ParserBundle\Domain\ValueObject\InputFile;
use App\ParserBundle\Domain\MemeImageCollection;
use App\ParserBundle\Domain\MemeImageParserInterface;

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