<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::post('posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::get('/response/{post:id}/{content}',[ \App\Http\Controllers\PostController::class, 'postResponse'])->name('post.postResponse');
    Route::get('/destroy/{post:id}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('post.destroy');
//    Route::get('profile', )
//    Route::get('/profile/{user:name}', [\App\Http\Controllers\PostController::class, 'profile'])->name('posts.profile');
});
