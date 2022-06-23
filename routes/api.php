<?php

use Illuminate\Support\Facades\Route;

## non-authorized routes.
Route::prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

## cart routes.
Route::prefix('cart')->namespace('Cart')->group(function () {
    Route::post('/', 'CartController@store');
    Route::put('/{id}', 'CartController@update');
    Route::delete('/{id}', 'CartController@delete');
    Route::get('/', 'CartController@index');
});

## authorized routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', 'AuthController@logout');

    ## category routes
    Route::prefix('categories')->namespace('Category')->group(function () {
        Route::get('/', 'CategoryController@index');
        Route::get('/{id}', 'CategoryController@show');
        Route::post('/', 'CategoryController@store');
        Route::put('/{id}', 'CategoryController@update');
        Route::delete('/{id}', 'CategoryController@delete');
    });

    ## product routes
    Route::prefix('products')->namespace('Product')->group(function () {
        Route::get('/', 'ProductController@index');
        Route::get('/{id}', 'ProductController@show');
        Route::post('/', 'ProductController@store');
        Route::put('/{id}', 'ProductController@update');
        Route::delete('/{id}', 'ProductController@delete');
    });
});
