<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\App_review;
use App\Models\Book_review;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            Log::info($users);
            return response()->json($users);
        } catch (\Exception $e) {
            Log::error('Ошибка при получении пользователей: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при получении пользователей'], 500);
        }
    }

    public function deleteUser($idUser)
    {
        try {
            $user = User::findOrFail($idUser)->delete();
            return response()->json("success");
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении пользователя: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при удалении пользователя'], 500);
        }
    }

    public function indexBook()
    {
        try {
            $books = Book::all();
            return response()->json($books);
        } catch (\Exception $e) {
            Log::error('Ошибка при получении книг: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при получении книг'], 500);
        }
    }

    public function createBook(Request $request)
    {
        try {
            Log::info($request);
            $data = $request->validate([
                'author' => 'required',
                'title' => 'required',
                'content' => 'nullable',
                'description' => 'required',
                'path_to_image' => 'required|image|mimes:png,jpg',
                'path_to_audio' => 'nullable|file|mimes:mp3',
                'type' => 'required|max:5|min:4'
            ]);

            $imagePath = $request->file('path_to_image')->store('public/images');
            $data['path_to_image'] = url(\Storage::url($imagePath));

            if ($request->hasFile('path_to_audio')) {
                $audioPath = $request->file('path_to_audio')->store('public/audio');
                $data['path_to_audio'] = url(\Storage::url($audioPath));
            } else {
                $audioPath = null;
                $data['path_to_audio'] = null;
            }

            $book = Book::query()->create([
                'author' => $data['author'],
                'title' => $data['title'],
                'content' => $data['content'],
                'description' => $data['description'],
                'path_to_image' => $data['path_to_image'],
                'path_to_audio' => $data['path_to_audio'],
                'type' => $data['type']
            ]);

            $books = Book::all();

            return response()->json($books);
        } catch (\Exception $e) {
            Log::error('Ошибка при создании книги: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при создании книги', $e->getMessage()], 500);
        }
    }


    public function deleteBook($idBook)
    {
        try {
            $book = Book::findOrFail($idBook);
            $book_path_image = str_replace('http://localhost:8000/storage/', 'public/', $book->path_to_image);
            Storage::delete($book_path_image);
            if ($book->path_to_audio != null) {
                $book_path_audio = str_replace('http://localhost:8000/storage/', 'public/', $book->path_to_audio);
                Storage::delete($book_path_audio);
            }
            $book->delete();
            return response()->json("success");
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении книги: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при удалении книги'], 500);
        }
    }

    public function indexAppReview()
    {
        try {
            $app_reviews = App_review::all();
            return response()->json($app_reviews);
        } catch (\Exception $e) {
            Log::error('Ошибка при получении отзывов на приложение: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при получении отзывов на приложение'], 500);
        }
    }

    public function deleteAppReview($idAppReview)
    {
        try {
            $app_review = App_review::findOrFail($idAppReview)->delete();
            return response()->json("success");
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении отзыва на приложение: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при удалении отзыва на приложение'], 500);
        }
    }

    public function indexBookReview()
    {
        try {
            $bookReviews = Book_review::all();
            return response()->json($bookReviews);
        } catch (\Exception $e) {
            Log::error('Ошибка при получении отзывов книг: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при получении отзывов книг'], 500);
        }
    }

    public function deleteBookReview($idBookReview)
    {
        try {
            $bookReview = Book_review::findOrFail($idBookReview)->delete();
            return response()->json("success");
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении отзыва книги: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при удалении отзыва книги'], 500);
        }
    }
}
