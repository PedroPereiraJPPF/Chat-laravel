<?php

namespace App\Repository\Conversation;

use App\Models\Conversation;
use App\Repository\BaseRepository;

class ConversationRepository extends BaseRepository
{
    public function __construct(Conversation $conversation)
    {
        Parent::__construct($conversation);
    }
}
