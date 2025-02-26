<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});

//uso dei controllers x le rotte
Route::resource('books',BookController::class)  //show the result with php artisan route:list
    ->only(['index','show']);
Route::resource('books.reviews',ReviewController::class)
    ->scoped(['review' => 'book'])
    ->only(['create','store']);
