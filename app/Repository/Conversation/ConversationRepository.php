<?php

namespace App\Repository\Conversation;

use App\Models\Conversation;
use App\Models\User;
use App\Repository\BaseRepository;

class ConversationRepository extends BaseRepository
{
    public function __construct(Conversation $conversation)
    {
        Parent::__construct($conversation);
    }

    public function getConversationsByUserId(User $user, array $relations, int $per_page = 5)
    {
        return $user->conversations()->with($relations)->paginate($per_page);
    }
}
