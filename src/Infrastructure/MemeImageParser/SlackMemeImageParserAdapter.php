<?php

namespace App\Infrastructure\MemeImageParser;

use App\Domain\MemeImageCollection;
use App\Domain\MemeImageParserInterface;
use App\Domain\ValueObject\InputFile;
use App\Infrastructure\Shared\FileUploader\ExportFile;
use App\Infrastructure\Shared\FileUploader\FileUploaderInterface;
use App\Infrastructure\Shared\Reader\Reader;

class SlackMemeImageParserAdapter implements MemeImageParserInterface
{
    private FileUploaderInterface $fileUploader;
    private Reader $reader;

    public function __construct(FileUploaderInterface $fileUploader, Reader $reader)
    {
        $this->fileUploader = $fileUploader;
        $this->reader = $reader;
    }


    public function getMemeImagesFromFile(InputFile $file): MemeImageCollection
    {
        $exportFile = new ExportFile(
            $file->getFilePath()
        );

        $uploadedExportFile = $this->fileUploader->uploadFile($exportFile, $file->getFileName());
        return $this->reader->getUrls($uploadedExportFile);
    }
}