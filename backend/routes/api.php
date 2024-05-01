<?php

use App\Http\Controllers\FriendRequestController;
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