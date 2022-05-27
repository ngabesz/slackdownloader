<?php


namespace Application\UseCase;


class UploadFileRequest
{

  protected $path;

  protected $name;

  public function __construct($path,$name)
  {
    $this->path = $path;
    $this->name = $name;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getName()
  {
    return $this->name;
  }

}