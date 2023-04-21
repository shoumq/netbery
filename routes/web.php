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

//Route::get('/', function () {
//    return Inertia::render('Profile', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/user/{user_login}', [App\Http\Controllers\ProfileController::class, 'index'])->name('user');
    Route::post('/user/update_status', [App\Http\Controllers\ProfileController::class, 'updateStatus'])->name('user');

    Route::post('/post/{user}', [App\Http\Controllers\PostController::class, 'store']);
    Route::post('/post_like/{post}', [App\Http\Controllers\PostController::class, 'postLike']);

    Route::get('/chat/{dialog_id}', [App\Http\Controllers\MessageController::class, 'chat']);
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index']);
    Route::post('/messages/{dialog_id}', [App\Http\Controllers\MessageController::class, 'store']);
    Route::post('/create_dialog', [App\Http\Controllers\MessageController::class, 'createDialog']);

    Route::get('/friends', [App\Http\Controllers\FriendsController::class, 'index'])->name('friends');
    Route::post('/search_friends', [App\Http\Controllers\FriendsController::class, 'search'])->name('search_friends');

    Route::get('/communities', [App\Http\Controllers\CommunityController::class, 'index'])->name('community');
    Route::get('/community/{community}', [App\Http\Controllers\CommunityController::class, 'getCommunity']);
    Route::get('/create_community', [App\Http\Controllers\CommunityController::class, 'create'])->name('create_community');
    Route::post('/create_community', [App\Http\Controllers\CommunityController::class, 'store']);
    Route::post('/create_community_post/{community}', [App\Http\Controllers\CommunityController::class, 'storePost']);
    Route::post('/subscribe_community/{community}', [App\Http\Controllers\CommunityController::class, 'subscribe']);
    Route::post('/unsubscribe_community/{community}', [App\Http\Controllers\CommunityController::class, 'unsubscribe']);

    Route::get('/users', [App\Http\Controllers\FriendsController::class, 'allUsers'])->name('allUsers');
    Route::get('/user', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/user', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/user', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
