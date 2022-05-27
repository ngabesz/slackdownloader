<?php


namespace Infrastructure\Service\Reader;


use Domain\MemeImageCollection;
use Domain\Reader;
use Domain\SlackExportFile;

class ExtensionAwareReader implements Reader
{
  protected $readers;

  public function addReader($extension, $reader){
    $this->readers[$extension] = $reader;
  }

  public function getUrls(SlackExportFile $file) : MemeImageCollection
  {

    $reader = $this->readers[$file->getExtension()];

    return $reader->getUrls($file);
  }
}