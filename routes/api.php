<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('register',[AuthController::class,'register'])->middleware('language');
Route::post('login',[AuthController::class,'login'])->middleware('language');
Route::get('email-verify',[AuthController::class,'EmailVerify'])->middleware('language');
Route::middleware('auth:sanctum')->group(function () {
Route::get('logout',[AuthController::class,'logout'])->middleware('language');
Route::get('/user',[AuthController::class,'findUser'])->middleware('language');
});
Route::apiResource('category',CategoryController::class)->middleware('language');