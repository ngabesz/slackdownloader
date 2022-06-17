<?php


namespace Infrastructure\Shared\Filesystem;


class File
{
  protected $name;

  protected $path;

  public function __construct($path)
  {
    $name = explode(DIRECTORY_SEPARATOR, $path);
    $this->name = end($name);
    $this->path = $path;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getExtension()
  {
    $re = explode('.', $this->name);
    return end($re);
  }
}