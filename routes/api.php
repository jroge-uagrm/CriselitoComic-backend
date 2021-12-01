<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('echo', function () {
        return "CriselitoComic-backend Web Services running...";
    });

    Route::apiResources([
        'users' => UserController::class,
    ]);
    Route::post('/login',[AuthController::class, 'login']);
});
