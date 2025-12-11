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
    $category = $request->input('category', 'all'); // all, author, title, subject
    $library = $request->input('library'); // library branch ID
    
    $holdings = \App\Models\Holding::with('library')
        ->where('status', 'available')
        ->when($library, function($q) use ($library) {
            $q->where('holding_branch_id', $library);
        })
        ->where(function($q) use ($query, $category) {
            if ($category === 'author') {
                $q->where('author', 'LIKE', "%{$query}%");
            } elseif ($category === 'title') {
                $q->where('title', 'LIKE', "%{$query}%");
            } elseif ($category === 'subject') {
                $q->where('category', 'LIKE', "%{$query}%");
            } else { // all
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('author', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%");
            }
        })
        ->limit(10)
        ->get(['id', 'title', 'author', 'isbn', 'category', 'available_copies', 'holding_branch_id']);
    
    return response()->json($holdings);
});