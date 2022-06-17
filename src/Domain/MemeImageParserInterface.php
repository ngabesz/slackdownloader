<?php

namespace Domain;

use Domain\ValueObject\InputFile;
use DomainException;

interface MemeImageParserInterface
{
    /**
     * @throws DomainException
     */
    public function getMemeImagesFromFile(InputFile $file): MemeImageCollection;
}