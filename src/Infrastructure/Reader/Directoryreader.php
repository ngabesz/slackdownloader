<?php


namespace Infrastructure\Reader;


use Domain\Service\Reader;

class Directoryreader extends Filereader implements Reader
{
  public function getUrls($path)
  {
    $urls = array();
    $files = $this->glob_recursive($path,"*.json");

    foreach ($files as $file){
      $u = parent::getUrls($file);
      if (!empty($u)){
        $urls = array_merge($urls, $u);
      }

    }
    return $urls;
  }

  protected function glob_recursive($base, $pattern, $flags = 0) {
    $flags = $flags & ~GLOB_NOCHECK;

    if (substr($base, -1) !== DIRECTORY_SEPARATOR) {
      $base .= DIRECTORY_SEPARATOR;
    }

    $files = $this->filesystem->glob($base.$pattern, $flags);
    if (!is_array($files)) {
      $files = [];
    }

    $dirs = $this->filesystem->glob($base.'*', GLOB_ONLYDIR|GLOB_NOSORT|GLOB_MARK);
    if (!is_array($dirs)) {
      return $files;
    }

    foreach ($dirs as $dir) {
      $dirFiles = $this->glob_recursive($dir, $pattern, $flags);
      $files = array_merge($files, $dirFiles);
    }

    return $files;
  }
}