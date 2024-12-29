<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FindController;
use App\Http\Controllers\PhoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware(['language'])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('email-verify', [AuthController::class, 'EmailVerify']);
Route::get('/user', [AuthController::class, 'findUser']);
Route::apiResource('categories', CategoryController::class);
});
Route::middleware(['language','auth:sanctum'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::apiResource('phones',PhoneController::class);
    Route::post('comments',[CommentController::class,'commentstore']);
    Route::delete('comments/{id}',[CommentController::class,'commentdestroy']);
    Route::get('search',[FindController::class,'search']);
});
