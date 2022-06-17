<?php

namespace Infrastructure\Shared\FileUploader;

use Infrastructure\Shared\Filesystem\File;
use Infrastructure\Shared\Filesystem\FilesystemInterface;

class LocalFileUploader implements FileUploaderInterface
{

  protected $filesystem;

  public function __construct(FilesystemInterface $filesystem)
  {
    $this->filesystem = $filesystem;
  }

  public function uploadFile(ExportFile $file,$uploadName): UploadedExportFile
  {
    $filesystemFile = new File($file->getPath());

    $uploaded = $this->filesystem->uploadFile($filesystemFile,$uploadName);
    return new UploadedExportFile($uploaded->getPath());
  }
}