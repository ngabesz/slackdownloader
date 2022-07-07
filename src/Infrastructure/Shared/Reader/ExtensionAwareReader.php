<?php

namespace App\Infrastructure\Shared\Reader;

use App\Domain\MemeImageCollection;
use App\Infrastructure\Shared\FileUploader\UploadedExportFile;

class ExtensionAwareReader implements Reader
{
  protected $readers;

  public function addReader($extension, $reader){
    $this->readers[$extension] = $reader;
  }

  public function getUrls(UploadedExportFile $file) : MemeImageCollection
  {

    $reader = $this->readers[$file->getExtension()];

    return $reader->getUrls($file);
  }
}