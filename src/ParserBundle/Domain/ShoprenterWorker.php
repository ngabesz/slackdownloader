<?php


namespace App\ParserBundle\Domain;


class ShoprenterWorker
{

  protected string $lastName;

  protected string $firstName;

  public function __construct($firstName,$lastName)
  {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
  }

  /**
   * @return string
   */
  public function getFirstName(): string
  {
    return $this->firstName;
  }

  /**
   * @return string
   */
  public function getLastName(): string
  {
    return $this->lastName;
  }
}