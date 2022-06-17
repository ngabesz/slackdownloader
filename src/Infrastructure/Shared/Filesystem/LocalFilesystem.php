<?php

namespace Infrastructure\Shared\Filesystem;

use ZipArchive;

class LocalFilesystem implements FilesystemInterface
{

  protected $uploadDir;

  public function __construct($uploadDir)
  {
    $this->uploadDir = $uploadDir;
  }

  public function getContents(File $file): string
  {
    return file_get_contents($file->getPath());
  }

  public function uploadFile(File $file,$uploadName): File
  {
    $upload = $this->uploadDir.$uploadName;

    if ( move_uploaded_file($file->getPath(), $upload)){
      return new File($upload);
    }
  }

  public function unZip(File $file)
  {
    $dir = $this->uploadDir . time();

    $zip = new ZipArchive;
    $res = $zip->open($file->getPath());

    $zip->extractTo($dir);
    $zip->close();

    return $dir;
  }

  public function globRecursive($base, $pattern, $flags = 0) {

    $files = $this->doGlobRecursive($base, $pattern, $flags );
    $result = array();

    foreach ($files as $file){
      $result[] = new File($file);
    }
    return $result;
  }

  protected function doGlobRecursive($base, $pattern, $flags = 0) {
    $flags = $flags & ~GLOB_NOCHECK;

    if (substr($base, -1) !== DIRECTORY_SEPARATOR) {
      $base .= DIRECTORY_SEPARATOR;
    }

    $files = glob($base.$pattern, $flags);
    if (!is_array($files)) {
      $files = [];
    }

    $dirs = glob($base.'*', GLOB_ONLYDIR|GLOB_NOSORT|GLOB_MARK);
    if (!is_array($dirs)) {
      return $files;
    }

    foreach ($dirs as $dir) {
      $dirFiles = $this->doGlobRecursive($dir, $pattern, $flags);
      $files = array_merge($files, $dirFiles);
    }
    return $files;
  }
}