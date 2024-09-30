<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/picture', [ProfileController::class, 'updateProfilePicture'])
    ->name('profile.picture.update');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    Route::post('posts/{post}/comments', [CommentController::class, 'store']);

    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);

    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('like.store');
    
    Route::delete('/posts/{post}/unlike', [LikeController::class, 'destroy'])->name('like.destroy');
});

require __DIR__.'/auth.php';