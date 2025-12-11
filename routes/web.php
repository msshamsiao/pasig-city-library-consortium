<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LibrariesController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ContactController;
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
Route::post('/search', [HomeController::class, 'search'])->name('home.search');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Libraries
Route::get('/libraries', [LibrariesController::class, 'index'])->name('libraries');

// Activities
Route::get('/activities', [ActivitiesController::class, 'index'])->name('activities');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Dashboard - Redirect to role-specific dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isSuperAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isMemberLibrarian()) {
        return redirect()->route('librarian.dashboard');
    } elseif ($user->isBorrower()) {
        return redirect()->route('borrower.reservations.index');
    }
    
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super_admin'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Analytics
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
    
    // Archive
    Route::get('/archive', [\App\Http\Controllers\Admin\ArchiveController::class, 'index'])->name('archive');
    
    // Audit Trail
    Route::get('/audit-trail', [\App\Http\Controllers\Admin\AuditTrailController::class, 'index'])->name('audit-trail');
    
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
    Route::patch('activities/{activity}/approve', [ActivityController::class, 'approve'])->name('activities.approve');
    Route::patch('activities/{activity}/reject', [ActivityController::class, 'reject'])->name('activities.reject');
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

/*
|--------------------------------------------------------------------------
| MEMBER LIBRARIAN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('librarian')->name('librarian.')->middleware(['auth', 'role:member_librarian'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Librarian\LibrarianDashboardController::class, 'index'])->name('dashboard');
    
    // Members Management (Upload Only)
    Route::get('/members', [\App\Http\Controllers\Librarian\MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [\App\Http\Controllers\Librarian\MemberController::class, 'create'])->name('members.create');
    Route::post('/members', [\App\Http\Controllers\Librarian\MemberController::class, 'store'])->name('members.store');
    Route::post('/members/upload', [\App\Http\Controllers\Librarian\MemberController::class, 'upload'])->name('members.upload');
    
    // Book Requests (Approve/Reject)
    Route::get('/book-requests', [\App\Http\Controllers\Librarian\BookRequestController::class, 'index'])->name('book-requests.index');
    Route::post('/book-requests/{bookRequest}/approve', [\App\Http\Controllers\Librarian\BookRequestController::class, 'approve'])->name('book-requests.approve');
    Route::post('/book-requests/{bookRequest}/reject', [\App\Http\Controllers\Librarian\BookRequestController::class, 'reject'])->name('book-requests.reject');
    
    // Books Management (Upload Only)
    Route::get('/books', [\App\Http\Controllers\Librarian\BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [\App\Http\Controllers\Librarian\BookController::class, 'create'])->name('books.create');
    Route::post('/books', [\App\Http\Controllers\Librarian\BookController::class, 'store'])->name('books.store');
    Route::post('/books/upload', [\App\Http\Controllers\Librarian\BookController::class, 'upload'])->name('books.upload');
    
    // Activities (Add)
    Route::get('/activities', [\App\Http\Controllers\Librarian\ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/create', [\App\Http\Controllers\Librarian\ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [\App\Http\Controllers\Librarian\ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [\App\Http\Controllers\Librarian\ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{activity}', [\App\Http\Controllers\Librarian\ActivityController::class, 'update'])->name('activities.update');
});

/*
|--------------------------------------------------------------------------
| BORROWER ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('borrower')->name('borrower.')->middleware(['auth', 'role:borrower'])->group(function () {
    // Reservations
    Route::get('/reservations', [\App\Http\Controllers\Borrower\ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [\App\Http\Controllers\Borrower\ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [\App\Http\Controllers\Borrower\ReservationController::class, 'destroy'])->name('reservations.cancel');
});

require __DIR__.'/auth.php';