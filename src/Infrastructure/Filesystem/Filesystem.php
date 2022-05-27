<?php


namespace Infrastructure\Filesystem;


interface Filesystem
{

  public function getContents(File $path);

  public function uploadFile(File $file,$uploadName);

  public function globRecursive($base, $pattern, $flags = 0);

  public function unZip(File $file);

}