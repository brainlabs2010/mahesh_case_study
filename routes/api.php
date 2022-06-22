<?php

use Illuminate\Support\Facades\Route;

## non-authorized routes.
Route::prefix('auth')->namespace('Api')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

## authorized routes
Route::prefix('auth')->middleware('auth:sanctum')->namespace('Api')->group(function () {
    Route::post('logout', 'AuthController@logout');
});