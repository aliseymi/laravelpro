<?php

use Illuminate\Support\Facades\Gate;
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
//    $user = \App\Models\User::find(4);
//    $user->notify(new \App\Notifications\LoginToWebsite());

//    $container = new \App\Container();
//    $container->bind('fooService',function (){
//        return new FooService();
//    });

//    if(Gate::allows('edit-user')){
//        return view('welcome');
//    }

//    $product = \App\Models\Product::find(2);
//    $comment = auth()->user()->comments()->create([
//        'comment' => 'this is my comment',
//        'commentable_id' => $product->id,
//        'commentable_type' => 'App\Models\Product'
//    ]);

//    $product->comments()->create([
//        'user_id' => auth()->user()->id,
//        'comment' => 'this is my second comment'
//    ]);


//$comment = \App\Models\Comment::find(1);
//return $comment->commentable;

//$product = \App\Models\Product::withCount('comments',)->get();
//return $product;

    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'callback']);

Route::get('auth/token',[\App\Http\Controllers\Auth\AuthTokenController::class,'getToken'])->name('2fa.token');
Route::post('auth/token',[\App\Http\Controllers\Auth\AuthTokenController::class,'postToken']);

Route::get('auth/github', [\App\Http\Controllers\Auth\GithubAuthController::class, 'redirect'])->name('auth.github');
Route::get('auth/github/callback', [\App\Http\Controllers\Auth\GithubAuthController::class, 'callback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/secret', function () {
    return 'secret';
})->middleware(['auth', 'password.confirm']);

Route::prefix('profile')->namespace('App\Http\Controllers\Profile')->middleware('auth')->group(function () {
    Route::get('/', 'indexController@index')->name('profile');
    Route::get('twofactor', 'twoFactorAuthController@manageTwoFactor')->name('profile.2fa.manage');
    Route::post('twofactor', 'twoFactorAuthController@postMangeTwoFactor');
    Route::get('twofactor/phone', 'tokenAuthController@getPhoneVerify')->name('profile.2fa.phone');
    Route::post('twofactor/phone', 'tokenAuthController@postPhoneVerify');
});

Route::get('products',[\App\Http\Controllers\ProductController::class,'index']);
Route::get('products/{product}',[\App\Http\Controllers\ProductController::class,'single']);

Route::post('comments',[\App\Http\Controllers\HomeController::class,'comment'])->name('send.comment');

