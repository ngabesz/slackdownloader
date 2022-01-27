<?php

namespace Infrastructure\Filesystem;

use Domain\Service\Filesystem;

class Local implements Filesystem
{

  public function getContents($path)
  {
    return file_get_contents($path);
  }

  public function glob($pattern, $flags = 0)
  {
    return glob($pattern,$flags);
  }
}