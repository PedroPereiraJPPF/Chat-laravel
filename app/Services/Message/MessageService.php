<?php

namespace App\Services\Message;

use App\Exceptions\Messages\MessageNotFoundException;
use App\Exceptions\Messages\UserCanNotEditMessageException;
use App\Repository\Message\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    public function __construct(public readonly MessageRepository $repository) {}

    public function getAllByConversation(mixed $conversationId, int $per_page = 15)
    {
        try {
            return $this->repository->getMessagesByConversation($conversationId, $per_page);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function find(int $id)
    {
        try {
            $message = $this->repository->find($id);
            if (!$message) {
                throw MessageNotFoundException::make();
            }
            return $message;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function insert(array $data)
    {
        try {
            $this->repository->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data)
    {
        try {
            $user = Auth::user();

            if (!$message = $this->repository->find($data['id'])) {
                throw MessageNotFoundException::make();
            }

            if ($user->id !== $message->id_sender) {
                throw UserCanNotEditMessageException::make($user);
            }

            $message->update($data);

            return $message;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            if (!$message = $this->repository->find($id)) {
                throw MessageNotFoundException::make();
            }

            return $message->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
