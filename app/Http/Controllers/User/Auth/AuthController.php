<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(AuthRequest $request)
    {
        try {
            $request = $request->only(
                'email', 'password'
            );

            $user = User::where('email', $request['email'])->first();

            if (!$user->tokens->isEmpty()) {
                return response()->json(["message" => "success", 'token' => $user->tokens()->first()->token], 200);
            }

            if (!$user || !Hash::check($request['password'], $user->password)) {
                throw ValidationException::withMessages([
                    "message" => "invalid credentials"
                ]);
            }

            return response()->json(["message" => "success", 'token' => $user->createToken($request['email'])->plainTextToken]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage(), "data" => ""], 500);
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $request = $request->only(
                'name', 'email', 'password'
            );

            if (User::where('email', $request['email'])->first()) {
                return response()->json(["message" => "error - user already exists", 'data' => ""], 422);
            }

            $user = User::create(['name' => $request['name'], 'email' => $request['email'], 'password' => bcrypt($request['password'])]);

            return response()->json(['message' => "success", 'data' => $user->only('id', 'name', 'email')]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage(), "data" => ""], 500);
        }
    }
}
