<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function auth(AuthRequest $request)
    {
        try {
            $data = $request->validated();

            if (!Auth::attempt($data)) {
                return response()->json(['Invalid data' => 'invalid data', 'code' => 422]);
            }
            $user = Auth::user();
            $token = $this->generateToken($user);
            $response = response()->json(['success' => true, 'token' => $token, 'isAdmin' => $user->isAdmin], 200);
            $response->withCookie(cookie('token', $token, 30));

            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка аутентификации'], 500);
        }
    }


    public function logout(): RedirectResponse
    {
        try {
            Session::flush();
            Auth::logout();
            return redirect()->route('login');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при выходе из системы'], 500);
        }
    }

    private function generateToken(User $user)
    {
        try {
            $token = $user->createToken("main")->plainTextToken;
            return $this->successResponse(compact("user", "token"));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при генерации токена'], 500);
        }
    }

    private function successResponse($data)
    {
        return response($data);
    }
}
