<?php

namespace Infrastructure\MemeImageParser;

use Domain\MemeImageCollection;
use Domain\MemeImageParserInterface;
use Domain\ValueObject\InputFile;
use Infrastructure\Shared\FileUploader\ExportFile;
use Infrastructure\Shared\FileUploader\FileUploaderInterface;
use Infrastructure\Shared\Reader\Reader;

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