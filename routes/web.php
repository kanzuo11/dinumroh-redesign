<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\InquiryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/beranda', [HomeController::class, 'index'])->name('beranda');

// Package Routes
Route::get('/paket-umrah', [PackageController::class, 'index'])->name('packages');
Route::get('/paket-umrah/{id}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/paket-umrah/search', [PackageController::class, 'search'])->name('packages.search');

// Static Pages
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Contact Form
Route::post('/kontak', [InquiryController::class, 'store'])->name('contact.store');

// API Routes for AJAX/Mobile App
Route::prefix('api')->group(function () {
    Route::get('/packages', [PackageController::class, 'api'])->name('api.packages');
    Route::get('/packages/{id}', [PackageController::class, 'apiShow'])->name('api.packages.show');
    Route::get('/packages/search', [PackageController::class, 'search'])->name('api.packages.search');
    Route::post('/inquiry', [InquiryController::class, 'apiStore'])->name('api.inquiry.store');
});

// Admin Routes (for future implementation)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/packages', function () {
        return view('admin.packages.index');
    })->name('admin.packages.index');
    
    Route::get('/inquiries', function () {
        return view('admin.inquiries.index');
    })->name('admin.inquiries.index');
});

// Redirect old URLs for SEO
Route::redirect('/home', '/', 301);
Route::redirect('/packages', '/paket-umrah', 301);
Route::redirect('/about', '/tentang-kami', 301);
Route::redirect('/contact', '/kontak', 301);
