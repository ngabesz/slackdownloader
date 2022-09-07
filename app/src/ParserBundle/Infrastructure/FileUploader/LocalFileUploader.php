<?php

namespace App\ParserBundle\Infrastructure\FileUploader;

use App\ParserBundle\Infrastructure\Shared\Filesystem\File;
use App\ParserBundle\Infrastructure\Shared\Filesystem\FilesystemInterface;

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
