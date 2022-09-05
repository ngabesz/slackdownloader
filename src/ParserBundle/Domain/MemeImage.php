<?php

namespace App\ParserBundle\Domain;

class MemeImage
{

  private string $url;

  public function __construct(string $url)
  {
    $this->url = $url;
  }

  public function getUrl(): string
  {
    return $this->url;
  }
}