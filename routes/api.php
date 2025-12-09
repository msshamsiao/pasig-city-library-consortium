<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('cors')->group(function () {
    // Books
    Route::get('/books', 'BookController@index');
    Route::get('/books/{id}', 'BookController@show');
    Route::post('/books', 'BookController@store');
    Route::put('/books/{id}', 'BookController@update');
    Route::delete('/books/{id}', 'BookController@destroy');

    // Authentication
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout')->middleware('auth:api');
});