<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Book_review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewBookController extends Controller
{
    public function index($idBook)
    {
        try {
            $user = Auth::user();
            $book = Book::findOrFail($idBook, ['path_to_image', 'title', 'author']);
            $reviews = Book_review::with('user')
                ->where('book_id', $idBook)
                ->where('user_id', '!=', $user->id)
                ->get();
            $userReview = Book_review::where('user_id', $user->id)->where('book_id', $idBook)->first();

            return response()->json(['book' => $book, 'reviews' => $reviews, 'userReview' => $userReview]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при получении отзывов на книгу'], 500);
        }
    }

    public function createReview($idBook, Request $request)
    {
        try {
            $user = Auth::user();

            $data = $request->validate([
                "book_id" => "required",
                "content" => "nullable|string",
                "count_star" => "required"
            ]);

            $review = Book_review::query()->create([
                'content' => $data['content'],
                'count_star' => $data['count_star'],
                'user_id' => $user->id,
                'book_id' => $data['book_id'],
            ]);

            $userReview = Book_review::where('user_id', $user->id)->where('book_id', $data['book_id'])->first();
            Log::info($userReview);
            return response()->json($userReview);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при создании отзыва'], 500);
        }
    }

    public function updateReview($idBook, Request $request)
    {
        try {
            $user = Auth::user();
            $review = Book_review::where('user_id', $user->id)->where('book_id', $idBook)->first();

            $data = $request->validate([
                "content" => "nullable|string",
                "count_star" => "max:5|min:1",
            ]);

            $review->update(['content' => $data['content']]);
            $review->update(['count_star' => $data['count_star']]);
            $review->save();

            return response()->json($review);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при обновлении отзыва'], 500);
        }
    }

    public function deleteReview($idBook)
    {
        try {
            $user = Auth::user();
            $review = Book_review::where('user_id', $user->id)->where('book_id', $idBook)->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при удалении отзыва'], 500);
        }
    }
}
