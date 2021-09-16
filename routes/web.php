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

Auth::routes(['verify' => true]);

Route::get('auth/google',[\App\Http\Controllers\Auth\GoogleAuthController::class,'redirect'])->name('auth.google');
Route::get('auth/google/callback',[\App\Http\Controllers\Auth\GoogleAuthController::class,'callback']);

Route::get('auth/github',[\App\Http\Controllers\Auth\GithubAuthController::class,'redirect'])->name('auth.github');
Route::get('auth/github/callback',[\App\Http\Controllers\Auth\GithubAuthController::class,'callback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/secret',function (){
    return 'secret';
})->middleware(['auth','password.confirm']);

Route::middleware('auth')->group(function (){
    Route::get('profile',[\App\Http\Controllers\ProfileController::class,'index'])->name('profile');
    Route::get('profile/twofactor',[\App\Http\Controllers\ProfileController::class,'manageTwoFactor'])->name('profile.2fa.manage');
    Route::post('profile/twofactor',[\App\Http\Controllers\ProfileController::class,'postMangeTwoFactor']);
});


