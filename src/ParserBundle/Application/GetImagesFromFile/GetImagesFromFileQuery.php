<?php

namespace App\ParserBundle\Application\GetImagesFromFile;

class GetImagesFromFileQuery
{
    private string $workerUserName;
    private string $workerPassword;
    private string $filePath;
    private string $fileName;

    public function __construct(
        string $workerUserName,
        string $workerPassword,
        string $filePath,
        string $fileName
    ) {
        $this->workerUserName = $workerUserName;
        $this->workerPassword = $workerPassword;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
    }

    public function getWorkerUserName(): string
    {
        return $this->workerUserName;
    }

    public function getWorkerPassword(): string
    {
        return $this->workerPassword;
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
