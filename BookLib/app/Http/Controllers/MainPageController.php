<?php

namespace App\Http\Controllers;

use App\Models\App_review;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

class MainPageController extends Controller
{
    public function index()
    {
        try {
            $books = Book::limit(10)->get();
            $app_reviews = App_review::with('user')->get();
            return response()->json(['books' => $books, 'reviews' => $app_reviews]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при загрузке главной страницы'], 500);
        }
    }
}
