<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// Book Management Routes
Route::get('/books', [BookController::class, 'index']);         // List all books
Route::get('/books/{id}', [BookController::class, 'show']);      // Show details of a specific book
Route::post('/books', [BookController::class, 'store']);         // Create a new book
Route::put('/books/{id}', [BookController::class, 'update']);    // Update an existing book
Route::delete('/books/{id}', [BookController::class, 'destroy']); // Delete a book
