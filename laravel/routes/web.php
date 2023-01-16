<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\LanguageController;

use App\Models\Role as R;
use App\Models\Permission as P;

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

Route::get('/', function (Request $request) {
    $message = 'Loading welcome page';
    Log::info($message);
    $request->session()->flash('info', $message);
    return view('welcome');
});

Auth::routes();
require __DIR__.'/email-verify.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('mail/test', [MailController::class, 'test']);

Route::resource('files', FileController::class)
    ->middleware(['auth'/*, 'permission:'.P::FILES*/]);

Route::resource('posts', PostController::class)
    ->middleware(['auth', 'permission:'.P::POSTS]);

Route::controller(PostController::class)->group(function () {
    Route::post('/posts/{post}/likes', 'like')
        ->middleware(['auth','role:author'])
        ->name('posts.like');
    Route::delete('/posts/{post}/likes', 'unlike')
        ->middleware(['auth','role:author'])
        ->name('posts.unlike');
});

Route::resource('places', PlaceController::class)
    ->middleware(['auth', 'permission:'.P::PLACES]);

Route::controller(PlaceController::class)->group(function () {
    Route::post('/places/{place}/favorites', 'favorite')
        ->middleware(['auth','role:author'])
        ->name('places.favorite');
    Route::delete('/places/{place}/favorites', 'unfavorite')
        ->middleware(['auth','role:author'])
        ->name('places.unfavorite');
});

Route::get('/language/{locale}', [LanguageController::class, 'language']);