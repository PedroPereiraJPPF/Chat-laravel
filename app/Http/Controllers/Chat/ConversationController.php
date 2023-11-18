<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Services\Conversation\ConversationService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct(public readonly ConversationService $conversationService) {}

    public function index(Request $request)
    {
        try {
            $per_page = $request->per_page ?? 5;
            return response()->json(['message' => 'success', 'data' => $this->conversationService->listConversationByUser($per_page)], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "error - {$th->getMessage()}", 'data' => ''], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'users_id' => 'required'
            ]);

            return response()->json(['message' => 'success', 'data' => $this->conversationService->insert($request->all())], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "error - {$th->getMessage()}", 'data' => ''], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'users_id' => 'sometimes'
            ]);

            $conversation = $this->conversationService->update($request->all());

            return response()->json(['message' => 'success', 'data' => $conversation], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "error - {$th->getMessage()}", 'data' => ''], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);

            return response()->json(['message' => 'success', 'data' => $this->conversationService->delete($request->id)], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "error - {$th->getMessage()}", 'data' => ''], 500);
        }
    }
}
