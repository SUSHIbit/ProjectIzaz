<?php
// routes/web.php

use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\UserUpdateController as AdminUserUpdateController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\User\ServiceController as UserServiceController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\DocumentController as UserDocumentController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\User\UpdateController as UserUpdateController;
use App\Http\Controllers\User\FeedbackController as UserFeedbackController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public routes (Guest role)
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/portfolio', [PublicController::class, 'portfolio'])->name('portfolio');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/feedback', [PublicController::class, 'feedback'])->name('feedback');

// Disable registration if needed (For Admin-only registration)
// Uncomment this to disable registration
// Route::get('/register', function () {
//     return redirect('/login');
// })->name('register');

// Auth routes (handled by Laravel Breeze)
require __DIR__.'/auth.php';

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Services Management
    Route::resource('services', AdminServiceController::class, ['as' => 'admin']);
    
    // Portfolio Management
    Route::resource('portfolio', AdminPortfolioController::class, ['as' => 'admin']);
    Route::post('/portfolio/{project}/images', [AdminPortfolioController::class, 'addImages'])->name('admin.portfolio.images.store');
    Route::delete('/portfolio/images/{image}', [AdminPortfolioController::class, 'removeImage'])->name('admin.portfolio.images.destroy');
    
    // Booking Management
    Route::resource('bookings', AdminBookingController::class, ['as' => 'admin']);
    Route::post('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.status');
    
    // Service Availability Management
    Route::get('/services/{service}/availability', [AdminServiceController::class, 'availability'])->name('admin.services.availability');
    Route::post('/services/{service}/availability', [AdminServiceController::class, 'storeAvailability'])->name('admin.services.availability.store');
    Route::delete('/availability/{availability}', [AdminServiceController::class, 'destroyAvailability'])->name('admin.services.availability.destroy');
    
    // Document Management
    Route::resource('documents', AdminDocumentController::class, ['as' => 'admin']);
    Route::get('/documents/user/{user}', [AdminDocumentController::class, 'userDocuments'])->name('admin.documents.user');
    Route::post('/documents/{document}/status', [AdminDocumentController::class, 'updateStatus'])->name('admin.documents.status');
    
    // Payment Management
    Route::resource('payments', AdminPaymentController::class, ['as' => 'admin']);
    Route::get('/payments/user/{user}', [AdminPaymentController::class, 'userPayments'])->name('admin.payments.user');
    
    // User Update Management
    Route::resource('updates', AdminUserUpdateController::class, ['as' => 'admin']);
    Route::get('/updates/user/{user}', [AdminUserUpdateController::class, 'userUpdates'])->name('admin.updates.user');
    Route::post('/updates/{update}/images', [AdminUserUpdateController::class, 'addImages'])->name('admin.updates.images.store');
    Route::delete('/updates/images/{image}', [AdminUserUpdateController::class, 'removeImage'])->name('admin.updates.images.destroy');
    
    // Feedback Management
    Route::resource('feedback', AdminFeedbackController::class, ['as' => 'admin']);
    Route::post('/feedback/{feedback}/approve', [AdminFeedbackController::class, 'approve'])->name('admin.feedback.approve');
    
    // Team Management
    Route::resource('team', TeamController::class, ['as' => 'admin']);
});

// User routes
Route::prefix('user')->middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // Services
    Route::get('/services', [UserServiceController::class, 'index'])->name('user.services.index');
    Route::get('/services/{service}', [UserServiceController::class, 'show'])->name('user.services.show');
    
    // Bookings
    Route::get('/bookings', [UserBookingController::class, 'index'])->name('user.bookings.index');
    Route::get('/bookings/create/{service}', [UserBookingController::class, 'create'])->name('user.bookings.create');
    Route::post('/bookings', [UserBookingController::class, 'store'])->name('user.bookings.store');
    Route::get('/bookings/{booking}', [UserBookingController::class, 'show'])->name('user.bookings.show');
    
    // Documents
    Route::get('/documents', [UserDocumentController::class, 'index'])->name('user.documents.index');
    Route::get('/documents/{document}', [UserDocumentController::class, 'show'])->name('user.documents.show');
    Route::post('/documents/{document}/sign', [UserDocumentController::class, 'uploadSigned'])->name('user.documents.sign');
    
    // Payments
    Route::get('/payments', [UserPaymentController::class, 'index'])->name('user.payments.index');
    Route::post('/payments/{paymentItem}/receipt', [UserPaymentController::class, 'uploadReceipt'])->name('user.payments.receipt');
    
    // Updates
    Route::get('/updates', [UserUpdateController::class, 'index'])->name('user.updates.index');
    Route::get('/updates/{update}', [UserUpdateController::class, 'show'])->name('user.updates.show');
    
    // Feedback
    Route::get('/feedback', [UserFeedbackController::class, 'index'])->name('user.feedback.index');
    Route::get('/feedback/create', [UserFeedbackController::class, 'create'])->name('user.feedback.create');
    Route::post('/feedback', [UserFeedbackController::class, 'store'])->name('user.feedback.store');
});