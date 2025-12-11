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

// Holdings search endpoint
Route::get('/holdings/search', function (Request $request) {
    $query = $request->input('q');
    
    $holdings = \App\Models\Holding::where('status', 'available')
        ->where(function($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
              ->orWhere('author', 'LIKE', "%{$query}%")
              ->orWhere('isbn', 'LIKE', "%{$query}%");
        })
        ->limit(10)
        ->get(['id', 'title', 'author', 'isbn', 'available_copies']);
    
    return response()->json($holdings);
});