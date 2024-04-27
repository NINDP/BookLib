<?php

namespace App\Http\Controllers;

use App\Models\Book_review;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $books = Book::where('type', 'book')->get();

            if ($user) {
                foreach ($books as $book) {
                    $book->isLike = $book->users()->where('user_id', $user->id)->where('isLike', true)->exists();
                }
            }

            return response()->json($books);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при получении списка книг'], 500);
        }
    }

    public function setLike(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $bookId = $request->id_book;
            $book = $user->books()->where('book_id', $bookId)->exists();

            if (!$book) {
                $user->books()->attach($bookId, ['isLike' => true]);
            } else {
                $user->books()->updateExistingPivot($bookId, ['isLike' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при установке отметки "Нравится" для книги'], 500);
        }
    }

    public function deleteLike($idBook)
    {
        try {
            $user = Auth::user();
            $book = Book::find($idBook);

            if ($book) {
                $user->books()->updateExistingPivot($idBook, ['isLike' => false]);
                return response()->json(['message' => 'Лайк успешно удален'], 200);
            } else {
                return response()->json(['error' => 'Книга не найдена'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при удалении лайка для книги'], 500);
        }
    }

    public function book($id)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $book = Book::findOrFail($id);
            $subscriptions = Subscription::whereHas('books', function ($query) use ($id) {
                $query->where('id_book', $id);
            })->get();

            $countBookReview = Book_review::where('book_id', $id)->count();

            if ($user) {
                $user_subcription = $user->id_subscription;
                $isLike = $user->books()->where('book_id', $book->id)->where('isLike', true)->exists();
                $book->isLike = $isLike;
                $lastPage = $user->books()->where('book_id', $book->id)->value('last_page');
                $lastTime = $user->books()->where('book_id', $book->id)->value('last_time');
                $book->lastPage = $lastPage;
                $book->lastTime = $lastTime;
                return response()->json(['book' => $book, 'subscriptions' => $subscriptions, 'user_sub' => $user_subcription, 'count_review' => $countBookReview]);
            } else {
                return response()->json(['book' => $book, 'subscriptions' => $subscriptions]);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при получении информации о книге'], 500);
        }
    }

    public function bookPart($id)
    {
        try {
            $book = Book::findOrFail($id);
            return response()->json($book);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при получении информации о части книги'], 500);
        }
    }

    public function setLastPage($idBook, Request $request)
    {
        try {
            $user = Auth::user();
            $book = Book::findOrFail($idBook);
            $lastPage = $user->books()->where('book_id', $idBook)->exists();

            if (!$lastPage) {
                $user->books()->attach($book, ['last_page' => $request->last_page]);
            } else {
                $user->books()->updateExistingPivot($book->id, ['last_page' => $request->last_page]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при установке последней страницы для книги'], 500);
        }
    }

    public function setLastTime($idBook, Request $request)
    {
        try {
            $user = Auth::user();
            $book = Book::findOrFail($idBook);
            $lastTime = $user->books()->where('book_id', $idBook)->exists();

            if (!$lastTime) {
                $user->books()->attach($book, ['last_time' => $request->last_time]);
            } else {
                $user->books()->updateExistingPivot($book->id, ['last_time' => $request->last_time]);
            }

            return response()->json(['last_time' => $request->last_time]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при установке последнего времени для книги'], 500);
        }
    }
}
