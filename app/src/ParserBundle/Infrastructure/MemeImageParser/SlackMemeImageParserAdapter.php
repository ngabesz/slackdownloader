<?php

namespace App\ParserBundle\Infrastructure\MemeImageParser;

use App\ParserBundle\Domain\MemeImageCollection;
use App\ParserBundle\Domain\MemeImageParserInterface;
use App\ParserBundle\Domain\ValueObject\InputFile;
use App\ParserBundle\Infrastructure\FileReader\FileReaderInterface;
use App\ParserBundle\Infrastructure\FileUploader\TempFile;
use App\ParserBundle\Infrastructure\FileUploader\FileUploaderInterface;

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