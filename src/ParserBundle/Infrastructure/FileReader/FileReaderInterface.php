<?php

namespace App\ParserBundle\Infrastructure\FileReader;

use App\ParserBundle\Domain\MemeImageCollection;
use App\ParserBundle\Infrastructure\FileUploader\UploadedExportFile;

interface FileReaderInterface
{
    public function getUrls(UploadedExportFile $file) : MemeImageCollection;
}
