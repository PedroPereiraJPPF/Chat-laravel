<?php

namespace App\Exceptions\Messages;

use Exception;

class MessageNotFoundException extends Exception
{
    public function __construct($message, $code)
    {
        Parent::__construct($message, $code);
    }

    public static function make()
    {
        return new Self(message : "Mensage not found", code : 404);
    }
}
