<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/tokens/read-only', [AuthController::class, 'readOnlyToken']);

    // Needs the books:read ability (normal and read-only tokens)
    Route::middleware('abilities:books:read')->group(function () {
        Route::get('/books', [BookController::class, 'index']);
        Route::get('/books/{id}', [BookController::class, 'show']);
    });

    // Needs the books:write ability (normal tokens only)
    Route::middleware('abilities:books:write')->group(function () {
        Route::post('/books', [BookController::class, 'store']);
        Route::match(['put', 'patch'], '/books/{id}', [BookController::class, 'update']);
        Route::delete('/books/{id}', [BookController::class, 'destroy']);
    });
});