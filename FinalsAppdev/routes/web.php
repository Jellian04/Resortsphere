<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\ResortController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InquiryController;

Route::get('/', fn() => view('welcome'));
Route::view('/login', 'login')->name('login.form');
Route::view('/register', 'login')->name('register.form');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [CustomRegisterController::class, 'register'])->name('register');

Route::view('/welcome', 'welcome');
Route::view('/about', 'about');
Route::view('/resort1', 'resort1');
Route::view('/resort2', 'resort2');
Route::view('/resort3', 'resort3');
Route::view('/resort4', 'resort4');

Route::post('/inquiry/submit', [InquiryController::class, 'sendEmail'])->name('inquiry.submit');
Route::get('/resortowner', [ResortController::class, 'dashboard'])->name('resortowner.dashboard');
Route::prefix('resortowner')->name('resortowner.')->group(function () {
    // Resort Owner Dashboard
    Route::get('/dashboard', [ResortController::class, 'dashboard'])->name('dashboard'); // This will be the dashboard route

    // Other Routes
    Route::get('/resort/owner', [ResortController::class, 'resortowner'])->name('resort.owner');
    Route::get('/status', [ResortController::class, 'status'])->name('status');
    
    // Resort Registration
    Route::get('/register', [ResortController::class, 'create'])->name('register.form');
    Route::post('/register', [ResortController::class, 'store'])->name('register.store');
    
    // Resort Views
    Route::get('/resorts', [ResortController::class, 'index'])->name('resorts.show');
});

Route::get('/resortowner/dashboard', [ResortController::class, 'index'])->name('resortowner.dashboard');
Route::post('/resort/register', [ResortController::class, 'store'])->name('resort.register');
Route::get('/resortownerview', [ResortController::class, 'ownerView'])->name('resort.owner.view');


// Resort CRUD Operations
Route::prefix('resorts')->name('resorts.')->group(function () {
    Route::get('/', [ResortController::class, 'index'])->name('index');
    Route::get('/create', [ResortController::class, 'create'])->name('create');
    Route::post('/', [ResortController::class, 'store'])->name('store');
    Route::get('/{resort}', [ResortController::class, 'show'])->name('show');
    Route::get('/{resort}/edit', [ResortController::class, 'edit'])->name('edit');
    Route::put('/{resort}', [ResortController::class, 'update'])->name('update');
    Route::delete('/{resort}', [ResortController::class, 'destroy'])->name('destroy');
    
    // Image Handling
    Route::post('/{resort}/upload', [ResortController::class, 'upload'])->name('upload');
    Route::delete('/images/{image}', [ResortController::class, 'deleteImage'])->name('images.destroy');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/owners', [AdminController::class, 'listOwners'])->name('owners');
    Route::get('/users', [AdminController::class, 'showUsers'])->name('users');
    Route::post('/updatestatus/{id}', [AdminController::class, 'updateStatus'])->name('updateStatus');
    Route::put('/undo-reject/{id}', [AdminController::class, 'undoReject'])->name('undoReject');
    Route::post('/undoReject/{id}', [AdminController::class, 'undoReject']); // Optional fallback for older forms
    Route::delete('/owner/{id}', [AdminController::class, 'deleteOwner'])->name('deleteOwner');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
    Route::delete('/delete-rejected-owner/{id}', [AdminController::class, 'deleteRejectedOwner'])->name('deleteRejectedOwner');
});

// Pending Owner
Route::post('/pending-owners/store', [\App\Http\Controllers\PendingOwnerController::class, 'store'])->name('pending-owners.store');
