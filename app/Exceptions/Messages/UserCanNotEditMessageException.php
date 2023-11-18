<?php

namespace App\Exceptions\Messages;

use App\Models\User;
use Exception;

class UserCanNotEditMessageException extends Exception
{
    public function __construct($message, $code)
    {
        Parent::__construct($message, $code);
    }

    public static function make(User $user)
    {
        return new Self(message : "User {$user->name} can not edit this message", code : 404);
    }
}
