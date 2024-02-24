<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function auth(AuthRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return back()->withErrors('Invalid data');
        }
        return response()->json([
            "success" => true,
            "message" => "success",
            "token" => $this->generateToken(Auth::user()),
        ]);
    }


    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    private function generateToken(User $user) {
        $token = $user->createToken("main") -> plainTextToken;
        return $this->successResponse(compact("user","token"));
    }

    private function successResponse($data) {
        return response($data);
    }
}
