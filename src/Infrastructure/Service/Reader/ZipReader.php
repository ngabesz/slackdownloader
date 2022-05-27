<?php


namespace Infrastructure\Service\Reader;



use Domain\Reader;
use Domain\SlackExportFile;
use \Domain\MemeImageCollection;
use ZipArchive;

class ZipReader extends JsonReader implements Reader
{

  protected $dir;

  public function __construct(FilesystemAdapter $filesystem)
  {
    parent::__construct($filesystem);
  }

  public function getUrls(SlackExportFile $file) : \Domain\MemeImageCollection
  {
    $dir = $this->filesystem->unZip($file);

    $urls = new MemeImageCollection();
    $files = $this->filesystem->listFiles($dir,"*.json");

    foreach ($files as $f){

      $u = parent::getUrls($f);
      $urls->merge($u);

    }

    return $urls;

  }
}