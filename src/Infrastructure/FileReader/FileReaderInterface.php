<?php

namespace App\Infrastructure\FileReader;

use App\Domain\MemeImageCollection;
use App\Infrastructure\FileUploader\UploadedExportFile;

interface FileReaderInterface
{
    public function getUrls(UploadedExportFile $file) : MemeImageCollection;
}
