<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/',HomeController::class)->name('home');
Route::get('/language/{locale}',function($locale){
    session()->put('locale',$locale);
    return redirect()->back();
})->name('lang');
Route::get('/blog',[PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{post:slug}',[PostController::class, 'show'])->name('posts.show');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard',HomeController::class)->name('home');
//     // Route::get('/dashboard', function () {
//     //     return view('dashboard');
//     // })->name('dashboard');
// });
