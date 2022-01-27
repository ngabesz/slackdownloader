<?php


namespace Domain\Service;


interface Filesystem
{
  public function getContents($path);

  public function glob($pattern, $flags = 0);
}