<?php

namespace App\Services\Message;

use App\Exceptions\Messages\MessageNotFoundException;
use App\Repository\Message\MessageRepository;
use Illuminate\Http\Request;

class MessageService
{
    public function __construct(public MessageRepository $repository)
    {

    }

    public function getAll(int $per_page = 15)
    {
        try {
            $this->repository->getAll($per_page);
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
}
