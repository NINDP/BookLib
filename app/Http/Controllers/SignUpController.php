<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SignUpRequest;
class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->create([
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            "success" => true,
            "message" => "succes",
            "token" => $this->generateToken($user),
        ]);
    }
    private function generateToken(User $user) {
        $token = $user->createToken("main") -> plainTextToken;
        return $this->successResponse(compact("user","token"));
    }

    private function successResponse($data) {
        return response($data);
    }
}

