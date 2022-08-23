<?php

namespace App\Application\GetImagesFromFile;

class GetImagesFromFileQuery
{
    private string $filePath;
    private string $fileName;

    public function __construct(string $filePath, string $fileName)
    {
        $this->filePath = $filePath;
        $this->fileName = $fileName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}
