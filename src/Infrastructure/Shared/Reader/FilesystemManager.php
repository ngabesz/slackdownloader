<?php


namespace Infrastructure\Shared\Reader;


use Infrastructure\Shared\Filesystem\File;
use Infrastructure\Shared\Filesystem\FilesystemInterface;
use Infrastructure\Shared\FileUploader\UploadedExportFile;

class FilesystemManager
{
  protected $filesystem;

  public function __construct(FilesystemInterface $filesystem)
  {
    $this->filesystem = $filesystem;
  }

  public function getContents(UploadedExportFile $file){
    $filesystemFile = new File($file->getPath());
    return $this->filesystem->getContents($filesystemFile);
  }

  public function listFiles($dir,$pattern){
    $files = array();
    foreach ($this->filesystem->globRecursive($dir,$pattern) as $f){
      $files[] = new UploadedExportFile($f->getPath());
    }
    return $files;
  }

  public function unZip(UploadedExportFile $file)
  {
    $filesystemFile = new File($file->getPath());
    return $this->filesystem->unZip($filesystemFile);
  }
}