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

    public function getMessagesByConversation(mixed $conversationId, $per_page = 15)
    {
        return $this->model->where('id_conversation', $conversationId)->paginate($per_page);
    }
}
