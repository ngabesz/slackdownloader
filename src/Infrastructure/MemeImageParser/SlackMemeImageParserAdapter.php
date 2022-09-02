<?php

namespace App\Infrastructure\MemeImageParser;

use App\Domain\MemeImageCollection;
use App\Domain\MemeImageParserInterface;
use App\Domain\ValueObject\InputFile;
use App\Infrastructure\FileReader\FileReaderInterface;
use App\Infrastructure\FileUploader\TempFile;
use App\Infrastructure\FileUploader\FileUploaderInterface;

class SlackMemeImageParserAdapter implements MemeImageParserInterface
{
    private FileUploaderInterface $fileUploader;
    private FileReaderInterface $reader;

    public function __construct(FileUploaderInterface $fileUploader, FileReaderInterface $reader)
    {
        $this->fileUploader = $fileUploader;
        $this->reader = $reader;
    }

    public function getMemeImagesFromFile(InputFile $file): MemeImageCollection
    {
        $tempFile = new TempFile(
            $file->getFilePath()
        );

        $uploadedExportFile = $this->fileUploader->uploadFile($tempFile, $file->getFileName());
        return $this->reader->getUrls($uploadedExportFile);
    }
}