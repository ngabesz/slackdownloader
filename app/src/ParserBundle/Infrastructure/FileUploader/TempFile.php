<?php

namespace App\ParserBundle\Infrastructure\FileUploader;

use App\ParserBundle\Domain\Exception\DomainException;

use function end;
use function explode;

use const DIRECTORY_SEPARATOR;

class TempFile
{
    private string $path;
    private string $name;

    public function __construct($path)
    {
        $this->path = $path;
        $this->name = $this->getFileNameFromPath($path);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getName()
    {
        return $this->name;
    }

    private function getFileNameFromPath($path): string
    {
        $explodedPath = explode(DIRECTORY_SEPARATOR, $path);
        $name = end($explodedPath);

        if (!$name) {
            throw new DomainException($path . ' is not a file');
        }

        return $name;
    }
}