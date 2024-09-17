<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\Auth\AuthController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeUser']);

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/posts/create', [TopicController::class, 'create'])->name('posts.create');
Route::post('/posts', [TopicController::class, 'store'])->name('posts.store');

Route::post('/topics/{topic}/vote', [HomeController::class, 'vote']);

