<?php

namespace App\Domain;

use App\Domain\ValueObject\InputFile;
use DomainException;

interface MemeImageParserInterface
{
    /**
     * @throws DomainException
     */
    public function getMemeImagesFromFile(InputFile $file): MemeImageCollection;
}