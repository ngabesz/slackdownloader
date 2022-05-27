<?php


namespace Infrastructure\Service\FileUploader;


use Application\UseCase\UploadFileRequest;

use Domain\FileUploader;
use Domain\SlackExportFile;
use Infrastructure\Filesystem\File;
use Infrastructure\Filesystem\Filesystem;

class FilesystemAdapter implements FileUploader
{

  protected $filesystem;

  public function __construct(Filesystem $filesystem)
  {
    $this->filesystem = $filesystem;
  }

  public function uploadFile(SlackExportFile $file,$uploadName)
  {

    $filesystemFile = new File($file->getPath());

    $uploaded = $this->filesystem->uploadFile($filesystemFile,$uploadName);
    return new SlackExportFile($uploaded->getPath());
  }
}