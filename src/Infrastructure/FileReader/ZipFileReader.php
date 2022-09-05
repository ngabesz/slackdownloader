<?php

namespace App\Infrastructure\FileReader;

use App\Domain\MemeImageCollection;
use App\Infrastructure\FileUploader\UploadedExportFile;
use App\Infrastructure\Shared\Filesystem\FilesystemManager;

class ZipFileReader extends JsonFileReader implements FileReaderInterface
{
  protected $dir;

  public function __construct(FilesystemManager $filesystem)
  {
    parent::__construct($filesystem);
  }

  public function getUrls(UploadedExportFile $file) : MemeImageCollection
  {
    $dir = $this->filesystem->unZip($file);

    $urls = new MemeImageCollection();
    $files = $this->filesystem->listFiles($dir,"*.json");

    foreach ($files as $file){
      $u = parent::getUrls($file);
      $urls->merge($u);
    }

    return $urls;
  }
}
