<?php

namespace Infrastructure\Shared\Reader;

use Domain\MemeImageCollection;
use Infrastructure\Shared\FileUploader\UploadedExportFile;

interface Reader
{
  public function getUrls(UploadedExportFile $file) : MemeImageCollection;

}