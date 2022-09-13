<?php

namespace App\ParserBundle\Application\GetImagesFromFile;

class GetImagesFromFileQuery
{
    private string $filePath;
    private string $fileName;
    private int $workerId;

    public function __construct(
        string $filePath,
        string $fileName,
        int $workerId
    ) {
        $this->filePath = $filePath;
        $this->fileName = $fileName;
        $this->workerId = $workerId;
    }

    public function getWorkerId(): int
    {
        return $this->workerId;
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
