<?php

namespace App\ParserBundle\Infrastructure\FileReader;

use App\ParserBundle\Domain\MemeImageCollection;
use App\ParserBundle\Infrastructure\FileUploader\UploadedExportFile;

class ExtensionAwareFileReader implements FileReaderInterface
{
  private $readers;

  public function addReader($extension, $reader)
  {
    $this->readers[$extension] = $reader;
  }

  public function getUrls(UploadedExportFile $file) : MemeImageCollection
  {
    $reader = $this->readers[$file->getExtension()];
    return $reader->getUrls($file);
  }
}
