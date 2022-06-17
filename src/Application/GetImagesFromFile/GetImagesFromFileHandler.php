<?php

namespace Application\GetImagesFromFile;

use Domain\ValueObject\InputFile;
use Domain\MemeImageCollection;
use Domain\MemeImageParserInterface;

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