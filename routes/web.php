<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LibrariesController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\BookRequestController;
use App\Http\Controllers\Admin\LibraryController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (NO LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Libraries
Route::get('/libraries', [LibrariesController::class, 'index'])->name('libraries');

// Activities
Route::get('/activities', [ActivitiesController::class, 'index'])->name('activities');

// Service
Route::get('/service', [ServiceController::class, 'index'])->name('service');
Route::post('/service', [ServiceController::class, 'store'])->name('service.store');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Books Management
    Route::resource('books', BookController::class);
    Route::post('books/{book}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
    Route::post('books/{book}/return', [BookController::class, 'return'])->name('books.return');
    
    // Members Management
    Route::resource('members', MemberController::class);
    Route::post('members/{member}/suspend', [MemberController::class, 'suspend'])->name('members.suspend');
    Route::post('members/{member}/activate', [MemberController::class, 'activate'])->name('members.activate');
    
    // Book Requests Management
    Route::resource('book-requests', BookRequestController::class);
    Route::post('book-requests/{bookRequest}/approve', [BookRequestController::class, 'approve'])->name('book-requests.approve');
    Route::post('book-requests/{bookRequest}/reject', [BookRequestController::class, 'reject'])->name('book-requests.reject');
    Route::post('book-requests/{bookRequest}/complete', [BookRequestController::class, 'complete'])->name('book-requests.complete');
    
    // Libraries Management
    Route::resource('libraries', LibraryController::class);
    
    // Activities Management
    Route::resource('activities', ActivityController::class);
    Route::post('activities/{activity}/cancel', [ActivityController::class, 'cancel'])->name('activities.cancel');
    Route::post('activities/{activity}/participants', [ActivityController::class, 'addParticipant'])->name('activities.add-participant');
    Route::delete('activities/{activity}/participants/{user}', [ActivityController::class, 'removeParticipant'])->name('activities.remove-participant');
    
    // Statistics
    Route::get('statistics', [StatisticController::class, 'index'])->name('statistics');
    Route::get('statistics/export', [StatisticController::class, 'export'])->name('statistics.export');
    
    // Messages Management
    Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);
    Route::post('messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::post('messages/{message}/mark-read', [MessageController::class, 'markAsRead'])->name('messages.mark-read');
    
    // Reports & Analytics
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

// Breeze Authentication Routes
require __DIR__.'/auth.php';