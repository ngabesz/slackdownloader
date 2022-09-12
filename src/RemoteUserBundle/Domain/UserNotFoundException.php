<?php


namespace App\RemoteUserBundle\Domain;


class UserNotFoundException extends \Exception
{
  protected $message='User not found';
}