<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\MessageStoreRequest;
use App\Http\Requests\Messages\MessageUpdateRequest;
use App\Services\Message\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct(public readonly MessageService $messageService) {}

    public function index(Request $request)
    {
        try {
            $request->validate([
                'id_conversation' => 'required'
            ]);

            $per_page = $request->per_page ?? 15;
            return response()->json(['message' => 'success', 'data' => $this->messageService->getAllByConversation($request->id_conversation, $per_page)]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'data' => ''], 500);
        }
    }

    public function store(MessageStoreRequest $request) : JsonResponse
    {
        try {
            $request = $request->only(
                'id_conversation',
                'content'
            );

            $request['id_sender'] = Auth::user()->id;
            $message = $this->messageService->insert($request);
            return response()->json(['message' => 'success', 'data' => $message], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'data' => ''], 500);
        }
    }

    public function update(MessageUpdateRequest $request)
    {
        try {
            $message = $this->messageService->update($request->all());
            return response()->json(['message' => 'success', 'data' => $message], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'data' => ''], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);

            return response()->json(['message' => 'success', 'data' => $this->messageService->delete($request->id)], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'data' => ''], 500);
        }
    }
}
