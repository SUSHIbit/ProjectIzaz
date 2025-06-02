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
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AdminChatController;
use Illuminate\Support\Facades\Route;
use App\Models\Booking;
use App\Http\Controllers\ProfileController;

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
    })->name('dashboard');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
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
    Route::post('/portfolio/{portfolio}/images', [AdminPortfolioController::class, 'addImages'])->name('portfolio.images.store');
    Route::delete('/portfolio/images/{image}', [AdminPortfolioController::class, 'removeImage'])->name('portfolio.images.destroy');
    
    // Booking Management
    Route::resource('bookings', AdminBookingController::class);
    Route::put('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    
    // Document Management
    Route::get('/documents', [AdminDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/user/{user}', [AdminDocumentController::class, 'userDocuments'])->name('documents.user');
    Route::get('/documents/create', [AdminDocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [AdminDocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [AdminDocumentController::class, 'show'])->name('documents.show');
    Route::post('/documents/{document}/status', [AdminDocumentController::class, 'updateStatus'])->name('documents.status');
    Route::delete('/documents/{document}', [AdminDocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{document}/download-signed', [AdminDocumentController::class, 'downloadSigned'])->name('documents.download_signed');
    Route::post('/documents/bulk-store', [AdminDocumentController::class, 'bulkStore'])->name('documents.bulkStore');
    
    // Payment Management
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/user/{user}', [AdminPaymentController::class, 'userPayments'])->name('payments.user');
    Route::get('/payments/create', [AdminPaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [AdminPaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.status');
    Route::delete('/payments/{payment}', [AdminPaymentController::class, 'destroy'])->name('payments.destroy');
    
    // User Update Management
    Route::get('/updates', [AdminUserUpdateController::class, 'index'])->name('updates.index');
    Route::get('/updates/user/{user}', [AdminUserUpdateController::class, 'userUpdates'])->name('updates.user');
    Route::get('/updates/create', [AdminUserUpdateController::class, 'create'])->name('updates.create');
    Route::post('/updates', [AdminUserUpdateController::class, 'store'])->name('updates.store');
    Route::get('/updates/{update}', [AdminUserUpdateController::class, 'show'])->name('updates.show');
    Route::get('/updates/{update}/edit', [AdminUserUpdateController::class, 'edit'])->name('updates.edit');
    Route::put('/updates/{update}', [AdminUserUpdateController::class, 'update'])->name('updates.update');
    Route::delete('/updates/{update}', [AdminUserUpdateController::class, 'destroy'])->name('updates.destroy');
    Route::post('/updates/{update}/images', [AdminUserUpdateController::class, 'addImages'])->name('updates.images.store');
    Route::delete('/updates/images/{image}', [AdminUserUpdateController::class, 'removeImage'])->name('updates.images.destroy');
    
    // Feedback Management
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/{feedback}', [AdminFeedbackController::class, 'show'])->name('feedback.show');
    Route::post('/feedback/{feedback}/approve', [AdminFeedbackController::class, 'approve'])->name('feedback.approve');
    Route::delete('/feedback/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');
    
    // Team Management
    Route::resource('team', TeamController::class);
    
    // Chat Management
    Route::get('/chat', [AdminChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [AdminChatController::class, 'show'])->name('chat.show');
    Route::get('/chat/{id}/messages', [AdminChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [AdminChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/{id}/close', [AdminChatController::class, 'closeConversation'])->name('chat.close');
    
    // User Details Management (replacing Payment Types)
    Route::get('/user-details', [App\Http\Controllers\Admin\UserDetailController::class, 'index'])->name('user-details.index');
    Route::post('/user-details', [App\Http\Controllers\Admin\UserDetailController::class, 'store'])->name('user-details.store');
    Route::delete('/user-details/{userDetail}', [App\Http\Controllers\Admin\UserDetailController::class, 'destroy'])->name('user-details.destroy');
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
    Route::post('/payments/{payment}/receipt', [UserPaymentController::class, 'uploadReceipt'])->name('payments.receipt');
    
    // Updates
    Route::get('/updates', [UserUpdateController::class, 'index'])->name('updates.index');
    Route::get('/updates/{update}', [UserUpdateController::class, 'show'])->name('updates.show');
    
    // Feedback
    Route::get('/feedback', [UserFeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/create', [UserFeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [UserFeedbackController::class, 'store'])->name('feedback.store');

    // Loan Status
    Route::get('/loan-status', [App\Http\Controllers\User\LoanStatusController::class, 'index'])->name('loan.status');
});

// Chat routes for user
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/chat/conversation', [ChatController::class, 'getUserConversation']);
    Route::get('/chat/messages/{conversation_id}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
});

// Lawyer Routes
Route::middleware(['auth', 'role:lawyer'])->prefix('lawyer')->name('lawyer.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Lawyer\DashboardController::class, 'index'])->name('dashboard');
    
    // Document Routes
    Route::get('/documents', [App\Http\Controllers\Lawyer\DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}', [App\Http\Controllers\Lawyer\DocumentController::class, 'show'])->name('documents.show');
    Route::post('/documents/{document}/sign', [App\Http\Controllers\Lawyer\DocumentController::class, 'sign'])->name('documents.sign');
    
    // Payment Routes
    Route::get('/payments', [App\Http\Controllers\Lawyer\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [App\Http\Controllers\Lawyer\PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [App\Http\Controllers\Lawyer\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [App\Http\Controllers\Lawyer\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/receipt', [App\Http\Controllers\Lawyer\PaymentController::class, 'uploadReceipt'])->name('payments.receipt');

    // Loan Status Routes
    Route::get('/loan-status', [App\Http\Controllers\Lawyer\LoanStatusController::class, 'index'])->name('loan.status');
    Route::post('/loan-status/{user}/update', [App\Http\Controllers\Lawyer\LoanStatusController::class, 'update'])->name('loan.status.update');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});