<?php
use App\Http\Controllers\AdminController;

Route::get('/adminPanel/user', [AdminController::class, 'index']);
Route::delete('/adminPanel/user/{idUser}', [AdminController::class, 'deleteUser']);
Route::get('/adminPanel/book', [AdminController::class, 'indexBook']);
Route::post('/adminPanel/book/create', [AdminController::class, 'createBook']);
Route::delete('/adminPanel/book/{idBook}', [AdminController::class, 'deleteBook']);
Route::get('/adminPanel/appReview', [AdminController::class, 'indexAppReview']);
Route::delete('/adminPanel/appReview/{appReviewId}', [AdminController::class, 'deleteAppReview']);
Route::get('/adminPanel/bookReview', [AdminController::class, 'indexBookReview']);
Route::delete('/adminPanel/bookReview/{idBook}', [AdminController::class, 'deleteBookReview']);
Route::get('/adminPanel/bookSubscription', [AdminController::class, 'indexBookSub']);
Route::post('/adminPanel/bookSubscription', [AdminController::class, 'createBookSub']);
Route::delete('/adminPanel/bookSubscription/{idBookSub}', [AdminController::class, 'deleteBookSub']);
