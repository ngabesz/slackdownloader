<?php

namespace App\Infrastructure\Shared\Filesystem;

use App\Infrastructure\FileUploader\UploadedExportFile;

class FilesystemManager
{
  private $filesystem;

  public function __construct(FilesystemInterface $filesystem)
  {
    $this->filesystem = $filesystem;
  }

  public function getContents(UploadedExportFile $file): string
  {
    $filesystemFile = new File($file->getPath());
    return $this->filesystem->getContents($filesystemFile);
  }

    /**
     * @return UploadedExportFile[]
     */
  public function listFiles(string $dir, string $pattern): array
  {
    $files = [];
    foreach ($this->filesystem->globRecursive($dir, $pattern) as $f) {
      $files[] = new UploadedExportFile($f->getPath());
    }

    return $files;
  }

  public function unZip(UploadedExportFile $file): string
  {
    $filesystemFile = new File($file->getPath());
    return $this->filesystem->unZip($filesystemFile);
  }
}
