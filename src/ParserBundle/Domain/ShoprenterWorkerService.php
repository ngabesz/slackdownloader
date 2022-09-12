<?php


namespace App\ParserBundle\Domain;


use http\Exception;

interface ShoprenterWorkerService
{
  public function getWorkerByEmail(string $email) : ShoprenterWorker;

  public function authenticate($username,$password) : ShoprenterWorker;
}