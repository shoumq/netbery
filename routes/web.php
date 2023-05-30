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
    Route::post('/user/update_status', [App\Http\Controllers\ProfileController::class, 'updateStatus']);
    Route::post('/user/update_image', [App\Http\Controllers\ProfileController::class, 'updateImage']);

    Route::post('/post/{user}', [App\Http\Controllers\PostController::class, 'store']);
    Route::get('/delete_post/{post}', [App\Http\Controllers\PostController::class, 'delete']);
    Route::get('/post_like/{post}', [App\Http\Controllers\PostController::class, 'postLike']);

    Route::get('/chat/{dialog_id}', [App\Http\Controllers\MessageController::class, 'chat']);
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index']);
    Route::post('/messages/{dialog_id}', [App\Http\Controllers\MessageController::class, 'store']);
    Route::post('/create_dialog', [App\Http\Controllers\MessageController::class, 'createDialog']);

    Route::get('/friends', [App\Http\Controllers\FriendsController::class, 'index'])->name('friends');
    Route::post('/search_friends', [App\Http\Controllers\FriendsController::class, 'search'])->name('search_friends');

    Route::get('/communities', [App\Http\Controllers\CommunityController::class, 'index'])->name('community');
    Route::get('/my_communities/{user}', [App\Http\Controllers\CommunityController::class, 'myCommunity'])->name('myCommunity');
    Route::get('/community/{community}', [App\Http\Controllers\CommunityController::class, 'getCommunity']);
    Route::get('/create_community', [App\Http\Controllers\CommunityController::class, 'create'])->name('create_community');
    Route::post('/create_community', [App\Http\Controllers\CommunityController::class, 'store']);
    Route::post('/create_community_post/{community}', [App\Http\Controllers\CommunityController::class, 'storePost']);
    Route::get('/delete_community_post/{post}', [App\Http\Controllers\CommunityController::class, 'deletePost']);
    Route::post('/subscribe_community/{community}', [App\Http\Controllers\CommunityController::class, 'subscribe']);
    Route::post('/unsubscribe_community/{community}', [App\Http\Controllers\CommunityController::class, 'unsubscribe']);
    Route::post('/community/update_status/{community}', [App\Http\Controllers\CommunityController::class, 'updateStatus']);
    Route::post('/community/update_image', [App\Http\Controllers\CommunityController::class, 'updateImage']);
    Route::get('/community/post_like/{post}', [App\Http\Controllers\CommunityController::class, 'postLike']);

    Route::get('/news', [App\Http\Controllers\ProfileController::class, 'news']);

    Route::get('/users', [App\Http\Controllers\FriendsController::class, 'allUsers'])->name('allUsers');
    Route::get('/user', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/user/set_name', [App\Http\Controllers\ProfileController::class, 'setName']);
    Route::post('/user/set_surname', [App\Http\Controllers\ProfileController::class, 'setSurname']);
    Route::post('/user/set_email', [App\Http\Controllers\ProfileController::class, 'setEmail']);
    Route::post('/user/set_password', [App\Http\Controllers\ProfileController::class, 'setPassword']);
    Route::patch('/user', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/user', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/update_profile/', [App\Http\Controllers\ProfileController::class, 'updateProfile']);

    Route::get('/images/{user}', [App\Http\Controllers\ProfileController::class, 'pagePhotos']);
    Route::post('/add_images', [App\Http\Controllers\ProfileController::class, 'addImage']);
    Route::get('/del_images/{id}', [App\Http\Controllers\ProfileController::class, 'delImage']);

    Route::get('/update_online', [App\Http\Controllers\ProfileController::class, 'updateOnline']);
    Route::get('/get_online/{user}', [App\Http\Controllers\ProfileController::class, 'getOnline']);

    Route::post('/choose_icon', [App\Http\Controllers\ProfileController::class, 'chooseIcon']);
    Route::post('/add_icon', [App\Http\Controllers\ProfileController::class, 'addIcon']);

    Route::get('/market', [App\Http\Controllers\MarketController::class, 'renderPage']);

    Route::get('/test', [App\Http\Controllers\ProfileController::class, 'test']);
});

require __DIR__.'/auth.php';
