<?php

namespace App\ParserBundle\Domain;

use App\ParserBundle\Domain\ValueObject\InputFile;
use DomainException;

interface MemeImageParserInterface
{
    /**
     * @throws DomainException
     */
    public function getMemeImagesFromFile(InputFile $file): MemeImageCollection;
}