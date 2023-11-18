<?php

namespace App\Exceptions\Users;

use Exception;
use Illuminate\Database\Eloquent\Model;

class UserNotFoundException extends Exception
{
    public function __construct($message, $code)
    {
        Parent::__construct($message, $code);
    }

    public static function make(int $userId)
    {
        return new Self(message : "User with id {$userId} dont exists", code : 404);
    }
}
