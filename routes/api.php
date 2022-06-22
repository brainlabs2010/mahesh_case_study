<?php

use Illuminate\Support\Facades\Route;

## non-authorized routes.
Route::prefix('auth')->namespace('Api')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});


## authorized routes
Route::middleware('auth:sanctum')->namespace('Api')->group(function () {
    Route::post('auth/logout', 'AuthController@logout');

    ## product routes
    Route::prefix('products')->namespace('Product')->group(function () {
        Route::get('/', 'ProductController@index');
        Route::get('/{id}', 'ProductController@show');
        Route::post('/', 'ProductController@store');
        Route::put('/{id}', 'ProductController@update');
        Route::delete('/{id}', 'ProductController@delete');
    });
});
