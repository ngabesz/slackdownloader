<?php


namespace Application\UseCase;


use Domain\FileUploader;
use Domain\SlackExportFile;

class ReadImageUrlsFromUploadedFile
{
  protected $fileUploader;
  protected $reader;

  public function __construct(FileUploader $fileUploader, $reader)
  {
    $this->fileUploader = $fileUploader;
    $this->reader = $reader;
  }

  public function execute(UploadFileRequest $uploadFileRequest)
  {
    $exportFile = new SlackExportFile(
        $uploadFileRequest->getPath()
    );

    $uploadedExportFile = $this->fileUploader->uploadFile($exportFile,$uploadFileRequest->getName());

    return $this->reader->getUrls($uploadedExportFile);

  }
}