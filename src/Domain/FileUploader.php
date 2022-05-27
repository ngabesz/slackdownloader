<?php


namespace Domain;

interface FileUploader
{
  public function uploadFile(SlackExportFile $file, $uploadName);
}