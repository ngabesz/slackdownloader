<?php


namespace Infrastructure\Reader;


use Domain\Service\Filesystem;
use Domain\Service\Reader;

class Filereader implements Reader
{

  protected $filesystem;

  public function __construct( Filesystem $filesystem)
  {
    $this->filesystem = $filesystem;
  }

  public function getUrls($path)
  {
    $urls = array();
    $json = $this->filesystem->getContents($path);
    $posts = json_decode($json, TRUE);

    foreach ($posts as $p){
      foreach ($p['files'] as $f){
        if (isset($f['url_private_download'])){
          $urls[] = $f['url_private_download'];
        }
      }
    }
    return $urls;
  }
}