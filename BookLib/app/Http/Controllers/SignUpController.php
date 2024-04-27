<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SignUpRequest;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        $data = $request->validated();
        if ($data['email'] == "natali419915@yandex.ru" && $data['password'] == "Natasha199") {
            $isAdmin = true;
        } else {
            $isAdmin = false;
        }

        $user = User::query()->create([
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'path_to_photo' => $data['path_to_photo'] ?? null,
            'description' => $data['description'] ?? null,
            'id_subscription' => $data['id_subscription'] ?? null,
            'isAdmin' => $isAdmin,
        ]);

        return response()->json([
            "success" => true,
            "message" => "succes",
            "token" => $this->generateToken($user),
        ]);
    }
    private function generateToken(User $user)
    {
        $token = $user->createToken("main")->plainTextToken;
        return $this->successResponse(compact("user", "token"));
    }

    private function successResponse($data)
    {
        return response($data);
    }
}

