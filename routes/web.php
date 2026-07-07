<?php

use Illuminate\Support\Facades\Route;

// Import Controller Sisi Wisatawan / Publik
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;

// Import Controller Sisi Panel Admin
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PackageAdminController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\GalleryAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;

// 1. RUTE OTENTIKASI (AUTH)
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 2. RUTE PUBLIC / TAMU (TANPA LOGIN)
Route::get('/', [PackageController::class, 'index'])->name('beranda');
Route::get('/paket-tour', [PackageController::class, 'tour'])->name('paket.tour');
Route::get('/paket-tour/{slug}', [PackageController::class, 'show'])->name('paket.detail');

// Dipindahkan ke NewsController & GalleryController agar lebih terstruktur
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');

// 3. RUTE PROTEKSI WISATAWAN (WAJIB LOGIN)
Route::middleware(['auth'])->group(function () {
    
    // Fitur Transaksi & Pemesanan (Dikelola penuh oleh BookingController)
    Route::get('/booking/{id}', [BookingController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/booking/process/{id}', [BookingController::class, 'process'])->name('booking.process');
    Route::post('/booking/update-status', [BookingController::class, 'updateStatus'])->name('booking.update-status');
    Route::get('/reservations/{order_id}/download-ticket', [BookingController::class, 'downloadTicket'])->name('reservations.downloadTicket');
    
    // Fitur Manajemen Profil Wisatawan & Ulasan
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/reviews/store', [ProfileController::class, 'storeReview'])->name('reviews.storeCustomer');
});

// 4. RUTE PANEL ADMIN (SISTEM MANAGEMENT)
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