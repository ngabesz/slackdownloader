<?php


namespace Domain;


use function PHPUnit\Framework\throwException;

class SlackExportFile
{

  protected $path;

  protected $extension;

  protected $name;

  public function __construct($path)
  {

    $this->path = $path;
    $name = explode(DIRECTORY_SEPARATOR,$path);
    $this->name = end($name);

    if (!in_array($this->getExtension(),array('zip','json'))){
      throwException(new \Exception('wrong file format'));
    }
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

  public function getName()
  {
    return $this->name;
  }
}