<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResortOwnerController;
use App\Http\Controllers\PendingOwnerController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'login')->name('login.form');
Route::view('/register', 'register')->name('register.form');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [CustomRegisterController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

Route::view('/welcome', 'welcome');
Route::view('/inquiry', 'inquiry');
Route::view('/about', 'about');
Route::view('/resort1', 'resort1');
Route::view('/resort2', 'resort2');
Route::view('/resort3', 'resort3');
Route::view('/resort4', 'resort4');
Route::view('/resortowner', 'resortowner')->name('resort.owner');

Route::get('/resortowner/register', [ResortOwnerController::class, 'create'])->name('register.form');
Route::post('/resortowner/register', [ResortOwnerController::class, 'store'])->name('register.resort');
Route::get('/resortowner', [ResortOwnerController::class, 'showRegistrationForm'])->name('resort.owner');
Route::post('/resort-owner', [ResortOwnerController::class, 'store'])->name('resort-owner.store');
Route::get('/resortowner/status', [ResortOwnerController::class, 'getStatus'])->name('resortowner.status');
Route::post('/resort/register', [ResortOwnerController::class, 'store'])->name('resort.register');
Route::post('/resort/update', [ResortController::class, 'update'])->name('resort.update');
Route::get('/ownerstatus', [ResortOwnerController::class, 'ownerStatus'])->name('ownerstatus');



Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/pending-owners/store', [PendingOwnerController::class, 'store'])->name('pending-owners.store');
Route::post('/admin/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
Route::get('/adminowner', [AdminController::class, 'listOwners'])->name('adminowners');
Route::delete('/admin/owner/{id}', [AdminController::class, 'deleteOwner'])->name('admin.deleteOwner');
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete.user');
Route::get('/adminuser', [AdminController::class, 'showUsers'])->name('admin.users');


