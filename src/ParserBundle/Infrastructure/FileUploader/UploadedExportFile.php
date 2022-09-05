<?php

namespace App\ParserBundle\Infrastructure\FileUploader;

use App\ParserBundle\Domain\Exception\DomainException;
use function end;
use function explode;

class UploadedExportFile
{
    private string $path;
    private string $extension;
    private string $name;

    public function __construct($path)
    {
        $this->path = $path;
        $this->name = $this->getFileNameFromPath($path);
        $this->extension = $this->getExtensionFromFilename($this->name);

        if (!in_array($this->extension, ['zip','json'])) {
            throw new  DomainException('wrong file format');
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getName(): string
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

    private function getExtensionFromFilename($filename): string
    {
        $explodedFileName = explode('.', $filename);
        return end($explodedFileName);
    }
}
