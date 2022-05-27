<?php


namespace Infrastructure\Service\Reader;

use Domain\MemeImage;
use Domain\MemeImageCollection;
use Domain\Reader;
use Domain\SlackExportFile;


class JsonReader implements Reader
{

  protected $filesystem;

  public function __construct( FilesystemAdapter $filesystem)
  {
    $this->filesystem = $filesystem;
  }

  public function getUrls(SlackExportFile $file) : \Domain\MemeImageCollection
  {

    $urls = new MemeImageCollection();
    $json = $this->filesystem->getContents($file);

    $posts = json_decode($json, TRUE);

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