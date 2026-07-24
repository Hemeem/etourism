<?php

use Illuminate\Support\Facades\Route;

// Controller Sisi Wisatawan / Publik
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;

// Controller Sisi Panel Admin
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PackageAdminController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\GalleryAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;

// 1. RUTE OTENTIKASI 
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// 2. RUTE PUBLIC / TAMU (TANPA LOGIN)
Route::get('/', [PackageController::class, 'index'])->name('beranda');
Route::get('/paket-tour', [PackageController::class, 'tour'])->name('paket.tour');
Route::get('/paket-tour/{slug}', [PackageController::class, 'show'])->name('paket.detail');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');


// 3. RUTE WEBHOOK MIDTRANS (NOTIFICATION CALLBACK)
Route::post('/booking/update-status', [BookingController::class, 'updateStatus'])->name('booking.update-status');


// 4. RUTE PROTEKSI WISATAWAN (WAJIB LOGIN)
Route::middleware(['auth'])->group(function () {
    
    // Fitur Transaksi & Pemesanan
    Route::get('/booking/{id}', [BookingController::class, 'showBookingForm'])->name('booking.form');
    
    // Batasi eksekusi booking max 5x per menit per user untuk mencegah spam order
    Route::post('/booking/process/{id}', [BookingController::class, 'process'])
        ->middleware('throttle:5,1')
        ->name('booking.process');

    // === TAMBAHKAN ROUTE CHECKOUT DI SINI ===
    Route::get('/reservations/{order_id}/checkout', [BookingController::class, 'checkout'])->name('reservations.checkout');
        
    Route::get('/reservations/{order_id}/download-ticket', [BookingController::class, 'downloadTicket'])->name('reservations.downloadTicket');
    
    // Fitur Manajemen Profil Wisatawan & Ulasan
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/reviews/store', [ProfileController::class, 'storeReview'])->name('reviews.storeCustomer');
});


// 5. RUTE PANEL ADMIN (SISTEM MANAGEMENT)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard & Pelaporan
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::get('dashboard/print', [DashboardAdminController::class, 'printReport'])->name('dashboard.print');

    // CRUD Management (Resourceful)
    Route::resource('packages', PackageAdminController::class)->except(['create', 'show', 'edit']);
    Route::resource('news', NewsAdminController::class)->except(['create', 'show', 'edit']);
    Route::resource('galleries', GalleryAdminController::class)->except(['create', 'show', 'edit']);
    
    // Validasi & Moderasi Ulasan Wisatawan
    Route::get('reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{id}/status', [ReviewAdminController::class, 'updateStatus'])->name('reviews.updateStatus');
    Route::delete('reviews/{id}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');
});