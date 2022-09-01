<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('echo', function () {
        return "CriselitoComic-backend Web Services running...";
    });

    Route::apiResources([
        'users' => UserController::class,
    ]);
    Route::post('/login',[AuthController::class, 'login']);
    Route::post('/newUser',[AuthController::class, 'registerUser']);
    Route::get('/subscription',[RegisterController::class, 'subscription']);
    
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user',[AuthController::class, 'user']);
        Route::post('/upload',[DocumentController::class, 'upload']);
        Route::post('/trans',[DocumentController::class, 'saveTranslate']);
        Route::get('/documents',[DocumentController::class, 'getTranslations']);
        });
});
