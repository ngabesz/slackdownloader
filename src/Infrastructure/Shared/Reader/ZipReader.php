<?php


namespace App\Infrastructure\Shared\Reader;



use App\Domain\MemeImageCollection;
use App\Infrastructure\Shared\FileUploader\UploadedExportFile;

class ZipReader extends JsonReader implements Reader
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

    foreach ($files as $f){

      $u = parent::getUrls($f);
      $urls->merge($u);

    }

    return $urls;

  }
}