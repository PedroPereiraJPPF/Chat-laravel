<?php

namespace App\Repository\Message;

use App\Models\Message;
use App\Repository\BaseRepository;

class MessageRepository extends BaseRepository
{
    public function __construct(Message $message)
    {
        Parent::__construct($message);
    }
}
