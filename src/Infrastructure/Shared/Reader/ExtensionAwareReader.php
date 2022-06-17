<?php

namespace Infrastructure\Shared\Reader;

use Domain\MemeImageCollection;
use Infrastructure\Shared\FileUploader\UploadedExportFile;

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