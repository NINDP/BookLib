<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class AudioBookController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $audiobooks = Book::where('type', 'audio')->get();

            if ($user) {
                foreach ($audiobooks as $audiobook) {
                    $audiobook->isLike = $audiobook->users()->where('user_id', $user->id)->where('isLike', true)->exists();
                }
            }

            return response()->json($audiobooks);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при получении аудиокниг'], 500);
        }
    }
}
