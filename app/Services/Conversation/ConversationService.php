<?php

namespace App\Services\Conversation;

use App\Exceptions\Users\UserNotFoundException;
use App\Models\Conversation;
use App\Models\User;
use App\Repository\Conversation\ConversationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConversationService
{
    public function __construct(public readonly ConversationRepository $conversationRepository) {}

    public function listConversationByUser(int $per_page = 5)
    {
        try {
            return $this->conversationRepository->getConversationsByUserId(Auth::user(), ['users'], $per_page);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function find(int $id)
    {
        try {
            return $this->conversationRepository->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function insert(array $data)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $conversation = new Conversation();
            $conversation->status = 1;
            $conversation->save();

            $conversation->users()->attach($user);

            $users = User::findOrFail($data['users_id']);

            $conversation->users()->syncWithoutDetaching($users);

            DB::commit();
            return $conversation;
        } catch (ModelNotFoundException $e) {
            throw UserNotFoundException::make(current($e->getIds()));
        } catch (\Throwable $th) {
            DB::rollBack();
            info($th);
            throw $th;
        }
    }

    public function update(array $data)
    {
        try {
            DB::beginTransaction();

            if (!$conversation = $this->conversationRepository->find($data['id'])) {
                throw new ModelNotFoundException();
            }

            if ($data['users_id']) {
                $users = User::findOrFail($data['users_id']);
                $conversation->users()->syncWithoutDetaching($users);
            }

            DB::commit();
            return $this->conversationRepository->update($conversation, $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            info($th);
            throw $th;
        }
    }

    public function delete($conversationId)
    {
        try {
            DB::beginTransaction();

            if (!$conversation = $this->conversationRepository->find($conversationId)) {
                throw new ModelNotFoundException();
            }

            $this->conversationRepository->delete($conversation);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
