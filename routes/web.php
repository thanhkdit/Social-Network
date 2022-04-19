<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PostController;
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

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', [HomeController::class,'get_news_feed'])->name('home');
    Route::post('/', [MainController::class,'getPostJson']);
    Route::get('/profile', [HomeController::class,'getProfile'])->name('profile');
    Route::post('/profile/update', [UserController::class,'updateProfile'])->name('profile.update');
    Route::get('/personal', [HomeController::class,'getPersonalPage'])->name('personal.page');
    Route::post('/personal', [MainController::class,'getMyPostJson']);
    Route::get('/personal/friends', [HomeController::class,'getPersonalFriends'])->name('personal.friends');
    Route::get('/personal/requests', [HomeController::class,'getPersonalRequests'])->name('personal.requests');
    Route::get('/personal/images', [HomeController::class,'getPersonalImages'])->name('personal.images');
    Route::get('/other-personal/{id}', [HomeController::class,'getUserPage'])->name('other_person.page');
    Route::post('/other-personal/{id}', [MainController::class,'getUserPostJson']);
    Route::get('/other-personal/{id}/friends', [HomeController::class,'getUserFriends'])->name('other_person.friends');
    Route::get('/other-personal/{id}/images', [HomeController::class,'getUserImages'])->name('other_person.images');
    Route::post('/get-tab-chat', [ChatController::class,'get_tab_chat']);
    Route::post('/send-message', [ChatController::class,'send_message']);
    Route::post('/seen-message', [ChatController::class,'seen_message']);
    Route::post('/get-more-messages', [ChatController::class,'get_more_messages']);
    Route::post('/search-friends', [ChatController::class,'search_friends']);
    Route::post('/update-user-status-online', [UserController::class,'update_user_status_online']);
    Route::post('/update-user-status-offline', [UserController::class,'update_user_status_offline']);
    Route::post('/update-request', [UserController::class,'updateRequest']);
    Route::post('/add-calendar', [CalendarController::class,'store']);
    Route::post('/calendar/sync', [CalendarController::class,'syncCalendar']);
    Route::post('/destroy-calendar', [CalendarController::class,'destroy']);
    Route::post('/delete-all-calendar', [CalendarController::class,'deleteAll']);
    
    Route::post('/post/create', [PostController::class,'store']);
    Route::get('/post/{id}', [PostController::class,'show']);
    Route::post('/post/delete', [PostController::class,'delete']);
    Route::post('/post/like', [PostController::class,'likePost']);
    Route::post('/comment/like', [PostController::class,'likeComment']);
    Route::post('/reply/like', [PostController::class,'likeReply']);
    Route::post('/post/change-option', [PostController::class,'changeOption']);
    Route::post('/post/send-comment', [PostController::class,'comment']);
    Route::post('/post/send-reply', [PostController::class,'reply']);
    Route::post('/post/load-more-comments', [PostController::class,'loadMoreComments']);
    Route::post('/post/load-more-replies', [PostController::class,'loadMoreReplies']);
    Route::post('/seen-all-notifications', [PostController::class,'seenAllNotification']);
    Route::post('/seen-notification', [PostController::class,'seenNotification']);
    Route::post('/search', [UserController::class,'search']);
    Route::post('/search-message', [UserController::class,'searchUserMessage']);
});


require __DIR__.'/auth.php';
