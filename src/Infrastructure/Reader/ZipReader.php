<?php


namespace Infrastructure\Reader;


use Domain\Service\Filesystem;
use Domain\Service\Reader;
use ZipArchive;

class ZipReader extends Directoryreader implements Reader
{

  protected $dir;

  public function __construct(Filesystem $filesystem, $unzipdir)
  {
    parent::__construct($filesystem);
    $this->dir = $unzipdir;
  }

  public function getUrls($path){

    $dir = $this->dir.time();

    $zip = new ZipArchive;
    $res = $zip->open($path);

    $zip->extractTo($dir);
    $zip->close();

    return parent::getUrls($dir);
  }
}