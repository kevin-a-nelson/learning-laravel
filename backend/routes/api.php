<?php

use App\Http\Controllers\ChatboxController;
use App\Http\Controllers\ChatTextController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendshipController;
use App\Models\ChatText;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('contacts', [App\Http\Controllers\ContactController::class, 'contacts']);
Route::post('save_contact', [App\Http\Controllers\ContactController::class, 'saveContact']);

Route::get('login', [App\Http\Controllers\UserController::class, 'login']);
Route::post('user', [App\Http\Controllers\UserController::class, 'create']);
Route::get('users', [App\Http\Controllers\UserController::class, 'index']);

Route::get('posts', [App\Http\Controllers\PostController::class, 'index']);
Route::get('posts/{id}', [App\Http\Controllers\PostController::class, 'show']);
Route::post('posts', [App\Http\Controllers\PostController::class, 'create']);
Route::post('posts/{id}', [App\Http\Controllers\PostController::class, 'update']);
Route::delete('posts/{id}', [App\Http\Controllers\PostController::class, 'destroy']);

Route::get('comments', [App\Http\Controllers\CommentController::class, 'index']);
Route::get('comments/{id}', [App\Http\Controllers\CommentController::class, 'show']);
Route::post('comments', [App\Http\Controllers\CommentController::class, 'create']);
Route::post('comments/{id}', [App\Http\Controllers\CommentController::class, 'update']);
Route::delete('comments/{id}', [App\Http\Controllers\CommentController::class, 'destroy']);

Route::get('/friendRequests', [FriendRequestController::class, 'index']);
Route::get('/friendRequests/{id}', [FriendRequestController::class, 'show']);
Route::post('/friendRequests', [FriendRequestController::class, 'store']);
Route::put('/friendRequests/{id}', [FriendRequestController::class, 'update']);
Route::delete('/friendRequests/{id}', [FriendRequestController::class, 'destroy']);

Route::get('/friendships', [FriendshipController::class, 'index']);
Route::get('/friendships/{id}', [FriendshipController::class, 'show']);
Route::post('/friendships', [FriendshipController::class, 'store']);
Route::put('/friendships/{id}', [FriendshipController::class, 'update']);
Route::delete('/friendships/{id}', [FriendshipController::class, 'destroy']);

Route::get('/chatboxes', [ChatboxController::class, 'index']);
Route::get('/chatboxes/{id}', [ChatboxController::class, 'show']);
Route::post('/chatboxes', [ChatboxController::class, 'store']);
Route::put('/chatboxes/{id}', [ChatboxController::class, 'update']);
Route::delete('/chatboxes/{id}', [ChatboxController::class, 'destroy']);

Route::get('/chattexts', [ChatTextController::class, 'index']);
Route::get('/chattexts/{id}', [ChatTextController::class, 'show']);
Route::post('/chattexts', [ChatTextController::class, 'store']);
Route::put('/chattexts/{id}', [ChatTextController::class, 'update']);
Route::delete('/chattexts/{id}', [ChatTextController::class, 'destroy']);