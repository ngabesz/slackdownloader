<?php

namespace Infrastructure\Shared\Filesystem;

interface FilesystemInterface
{
  public function getContents(File $path): string;
  public function uploadFile(File $file,$uploadName): File;
  public function globRecursive($base, $pattern, $flags = 0);
  public function unZip(File $file);
}