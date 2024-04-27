<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index($str)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $books = Book::where('title', 'like', "%{$str}%")->orWhere('author', 'like', "%{$str}%")->get();

            if ($user) {
                foreach ($books as $book) {
                    $book->isLike = $book->users()->where('user_id', $user->id)->where('isLike', true)->exists();
                }
            }

            return response()->json($books);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при поиске книг'], 500);
        }
    }
}
