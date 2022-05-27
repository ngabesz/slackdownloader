<?php


namespace Infrastructure\Service\Reader;


use Domain\SlackExportFile;
use Infrastructure\Filesystem\File;
use Infrastructure\Filesystem\Filesystem;

class FilesystemAdapter
{
  protected $filesystem;

  public function __construct(Filesystem $filesystem)
  {
    $this->filesystem = $filesystem;
  }

  public function getContents(SlackExportFile $file){
    $filesystemFile = new File($file->getPath());
    return $this->filesystem->getContents($filesystemFile);
  }

  public function listFiles($dir,$pattern){
    $files = array();
    foreach ($this->filesystem->globRecursive($dir,$pattern) as $f){
      $files[] = new SlackExportFile($f->getPath());
    }
    return $files;
  }

  public function unZip(SlackExportFile $file)
  {
    $filesystemFile = new File($file->getPath());
    return $this->filesystem->unZip($filesystemFile);
  }
}