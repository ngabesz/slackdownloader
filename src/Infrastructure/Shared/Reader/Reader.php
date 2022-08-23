<?php

namespace App\Infrastructure\Shared\Reader;

use App\Domain\MemeImageCollection;
use App\Infrastructure\Shared\FileUploader\UploadedExportFile;

interface Reader
{
  public function getUrls(UploadedExportFile $file) : MemeImageCollection;

}