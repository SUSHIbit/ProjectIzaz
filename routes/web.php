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
use App\Models\Booking;

// Public routes (Guest role)
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/services/{service}', [PublicController::class, 'serviceDetail'])->name('service.detail');
Route::get('/portfolio', [PublicController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{project}', [PublicController::class, 'portfolioDetail'])->name('portfolio.detail');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/feedback', [PublicController::class, 'feedback'])->name('feedback');

// Auth routes (handled by Laravel Breeze)
require __DIR__.'/auth.php';

// Fallback dashboard route that redirects based on user role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    });
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Admin Dashboard with booking stats
    Route::get('/dashboard', function () {
        // Get all bookings with eager loading for performance
        $bookings = Booking::with(['user', 'service'])->latest()->get();
        return view('admin.dashboard', compact('bookings'));
    })->name('dashboard');

    // Services Management
    Route::resource('services', AdminServiceController::class);
    Route::get('/services/{service}/availability', [AdminServiceController::class, 'availability'])->name('services.availability');
    Route::post('/services/{service}/availability', [AdminServiceController::class, 'storeAvailability'])->name('services.availability.store');
    Route::delete('/availability/{availability}', [AdminServiceController::class, 'destroyAvailability'])->name('services.availability.destroy');
    Route::delete('/services/images/{image}', [AdminServiceController::class, 'removeImage'])->name('services.images.destroy');
    
    // Portfolio Management
    Route::resource('portfolio', AdminPortfolioController::class);
    Route::post('/portfolio/{project}/images', [AdminPortfolioController::class, 'addImages'])->name('portfolio.images.store');
    Route::delete('/portfolio/images/{image}', [AdminPortfolioController::class, 'removeImage'])->name('portfolio.images.destroy');
    
    // Booking Management
    Route::resource('bookings', AdminBookingController::class);
    Route::post('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    
    // Document Management
    Route::resource('documents', AdminDocumentController::class);
    Route::get('/documents/user/{user}', [AdminDocumentController::class, 'userDocuments'])->name('documents.user');
    Route::post('/documents/{document}/status', [AdminDocumentController::class, 'updateStatus'])->name('documents.status');
    
    // Payment Management
    Route::resource('payments', AdminPaymentController::class);
    Route::get('/payments/user/{user}', [AdminPaymentController::class, 'userPayments'])->name('payments.user');
    
    // User Update Management
    Route::resource('updates', AdminUserUpdateController::class);
    Route::get('/updates/user/{user}', [AdminUserUpdateController::class, 'userUpdates'])->name('updates.user');
    Route::post('/updates/{update}/images', [AdminUserUpdateController::class, 'addImages'])->name('updates.images.store');
    Route::delete('/updates/images/{image}', [AdminUserUpdateController::class, 'removeImage'])->name('updates.images.destroy');
    
    // Feedback Management
    Route::resource('feedback', AdminFeedbackController::class);
    Route::post('/feedback/{feedback}/approve', [AdminFeedbackController::class, 'approve'])->name('feedback.approve');
    
    // Team Management
    Route::resource('team', TeamController::class);
});

// User routes
Route::prefix('user')->middleware(['auth', 'user'])->name('user.')->group(function () {
    // User Dashboard
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // Services
    Route::get('/services', [UserServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [UserServiceController::class, 'show'])->name('services.show');
    
    // Bookings
    Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{service}', [UserBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [UserBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
    
    // Documents
    Route::get('/documents', [UserDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}', [UserDocumentController::class, 'show'])->name('documents.show');
    Route::post('/documents/{document}/sign', [UserDocumentController::class, 'uploadSigned'])->name('documents.sign');
    
    // Payments
    Route::get('/payments', [UserPaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{paymentItem}/receipt', [UserPaymentController::class, 'uploadReceipt'])->name('payments.receipt');
    
    // Updates
    Route::get('/updates', [UserUpdateController::class, 'index'])->name('updates.index');
    Route::get('/updates/{update}', [UserUpdateController::class, 'show'])->name('updates.show');
    
    // Feedback
    Route::get('/feedback', [UserFeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/create', [UserFeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [UserFeedbackController::class, 'store'])->name('feedback.store');
});