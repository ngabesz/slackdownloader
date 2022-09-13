<?php

namespace App\RemoteUserBundle\Application\Exception;

use function sprintf;

class UserNotFoundException extends ApplicationException
{
    protected $message = 'User not found | identifier: %s';

    public function __construct(string $identifier)
    {
        parent::__construct(sprintf($this->message, $identifier), 404);
    }
}