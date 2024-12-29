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
Route::post('register', [AuthController::class, 'register'])->middleware('language');
Route::post('login', [AuthController::class, 'login'])->middleware('language');
Route::get('email-verify', [AuthController::class, 'EmailVerify'])->middleware('language');
Route::middleware(['language','auth:sanctum'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'findUser']);
    Route::apiResource('phones',PhoneController::class);
    Route::post('comments',[CommentController::class,'commentstore']);
    Route::delete('comments/{id}',[CommentController::class,'commentdestroy']);
    Route::get('search',[FindController::class,'search']);
});
Route::apiResource('categories', CategoryController::class)->middleware('language');