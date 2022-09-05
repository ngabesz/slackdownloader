<?php

namespace App\Infrastructure\FileUploader;

use App\Infrastructure\Shared\Filesystem\File;
use App\Infrastructure\Shared\Filesystem\FilesystemInterface;

class LocalFileUploader implements FileUploaderInterface
{
  private $filesystem;

  public function __construct(FilesystemInterface $filesystem)
  {
    $this->filesystem = $filesystem;
  }

  public function uploadFile(TempFile $file,$uploadName): UploadedExportFile
  {
    $filesystemFile = new File($file->getPath());

    $uploaded = $this->filesystem->uploadFile($filesystemFile,$uploadName);
    return new UploadedExportFile($uploaded->getPath());
  }
}
