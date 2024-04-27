<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AudioBookController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppReviewController;
use App\Http\Controllers\ReviewBookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
    require_once __DIR__.'/admin.php';

Route::post('/login', [AuthController::class, 'auth']);
Route::post('/signup', [SignUpController::class, 'signUp']);

Route::middleware('auth:sanctum')->group(function () {
    // book
    Route::get('/book/{id}', [BookController::class, 'book']);
    Route::post('/book/{id}', [BookController::class, 'setLastPage']);
    Route::post('/catalog/books', [BookController::class, 'setLike']);
    Route::delete('/catalog/books/{idBook}', [BookController::class, 'deleteLike']);
    Route::post('/bookpage/{id}', [BookController::class, 'setLastTime']);

    // review
    Route::get('/review/{id}', [ReviewBookController::class, 'index']);
    Route::post('/review/{id}', [ReviewBookController::class, 'createReview']);
    Route::delete('/review/{id}', [ReviewBookController::class, 'deleteReview']);
    Route::patch('/review/{id}', [ReviewBookController::class, 'updateReview']);

    // user
    Route::get('/profile', [UserController::class, 'index']);
    Route::delete('/profile/edit/{id}', [UserController::class, 'deleteUser']);
    Route::get('/profile/edit', [UserController::class, 'indexEdit']);
    Route::post('/profile/edit', [UserController::class, 'profileUpdate']);
    Route::patch('/profile/edit/{id_subscription}', [UserController::class, 'updateSubscription']);
    Route::post('/profile/{id}', [AppReviewController::class, 'sendReview']);
    Route::post('/profile', [UserController::class, 'imageUpdate']);
    Route::delete('/profile/{id}', [AppReviewController::class, 'deleteReview']);
    Route::patch('/profile/{id_review}', [AppReviewController::class, 'updateReview']);
});

// book
Route::get('/bookpage/{id}', [BookController::class, 'book']);
Route::get('/book/{id}/excerpt', [BookController::class, 'bookPart']);
Route::get('/catalog/books', [BookController::class, 'index']);

// subscription
Route::get('/subscription', [SubscriptionController::class, 'index']);

// audiobook
Route::get('/catalog/audiobooks', [AudioBookController::class, 'index']);

// search 
Route::get('/search/{str}', [SearchController::class, 'index']);

Route::get('/slider', [MainPageController::class, 'index']);