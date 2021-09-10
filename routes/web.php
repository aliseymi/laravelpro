<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('auth/google',[\App\Http\Controllers\Auth\GoogleAuthController::class,'redirect'])->name('auth.google');
Route::get('auth/google/callback',[\App\Http\Controllers\Auth\GoogleAuthController::class,'callback']);

Route::get('auth/github',[\App\Http\Controllers\Auth\GithubAuthController::class,'redirect'])->name('auth.github');
Route::get('auth/github/callback',[\App\Http\Controllers\Auth\GithubAuthController::class,'callback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
