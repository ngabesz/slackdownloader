<?php


namespace Infrastructure\Shared\Reader;

use Domain\MemeImage;
use Domain\MemeImageCollection;
use Infrastructure\Shared\FileUploader\UploadedExportFile;


class JsonReader implements Reader
{
    private FilesystemManager $filesystem;

    public function __construct( FilesystemManager $filesystem)
    {
        $this->filesystem = $filesystem;
    }

  public function getUrls(UploadedExportFile $file) : \Domain\MemeImageCollection
  {

    $urls = new MemeImageCollection();
    $json = $this->filesystem->getContents($file);

    $posts = json_decode($json, true);

    foreach ($posts as $p){
      if (isset($p['files'])){
        foreach ($p['files'] as $f){
          if (isset($f['url_private_download'])){
            $urls[] = new MemeImage($f['url_private_download']);
          }
        }
      }
    }
    return $urls;
  }
}