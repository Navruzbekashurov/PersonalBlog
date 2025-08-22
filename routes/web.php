<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [ArticleController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('articles.comments.store');
    Route::get('myarticle',[ArticleController::class,'myArticles'])->name('myarticle');

    Route::get('/articles/tag/{tag}', [ArticleController::class, 'byTag'])->name('articles.byTag');

    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}', [ChatController::class, 'send'])->name('chat.send');
});

Route::get('/login', [UserController::class, 'showLogin'])->name('login.page');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('store');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');



Route::get('/auth/google/redirect', [UserController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [UserController::class, 'handleGoogleCallback'])->name('google.callback');
