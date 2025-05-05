<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\ResortOwnerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PendingOwnerController;
use App\Http\Controllers\InquiryController;

Route::get('/', fn() => view('welcome'));
Route::view('/login', 'login')->name('login.form');
Route::view('/register', 'login')->name('register.form');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [CustomRegisterController::class, 'register'])->name('register');

Route::view('/welcome', 'welcome');
Route::view('/inquiry', 'inquiry');
Route::view('/about', 'about');
Route::view('/resort1', 'resort1');
Route::view('/resort2', 'resort2');
Route::view('/resort3', 'resort3');
Route::view('/resort4', 'resort4');


Route::post('/submit-inquiry', [InquiryController::class, 'sendEmail'])->name('inquiry.submit');
Route::middleware(['auth'])->group(function () {
    Route::post('/register-resort', [ResortOwnerController::class, 'registerResort']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home', fn() => view('home'))->name('home');

    Route::get('/resortowner/register', [ResortOwnerController::class, 'create'])->name('resortowner.register.form');
    Route::post('/resortowner/register', [ResortOwnerController::class, 'store'])->name('resortowner.register.store');

   
    Route::get('/resortowner', [ResortOwnerController::class, 'index'])->name('resort.owner');
    Route::get('/resortowner/status', [ResortOwnerController::class, 'getStatus'])->name('resortowner.status');
    Route::get('/ownerstatus', [ResortOwnerController::class, 'ownerStatus'])->name('ownerstatus');
    Route::get('/resortownerview', [ResortOwnerController::class, 'viewResorts'])->name('resortownerview');
    Route::post('/upload', [YourController::class, 'upload'])->name('upload.route');
    Route::post('/delete-uploaded-image', [ResortOwnerController::class, 'delete'])->name('delete.uploaded.image');

   
    Route::get('/resort/register', [ResortOwnerController::class, 'create'])->name('resort.showRegisterForm');
    Route::post('/resort/register', [ResortOwnerController::class, 'store'])->name('resort.register');
    Route::get('/resort/edit/{id}', [ResortOwnerController::class, 'edit'])->name('resort.edit');
    Route::put('/resort/update/{id}', [ResortOwnerController::class, 'update'])->name('resort.update');
    Route::delete('/resort/delete/{id}', [ResortOwnerController::class, 'destroy'])->name('resort.delete');
});

Route::get('/adminowner', [AdminController::class, 'dashboard'])->name('adminowners');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/adminowner', [AdminController::class, 'listOwners'])->name('adminowners');
Route::get('/adminuser', [AdminController::class, 'showUsers'])->name('admin.users');
Route::post('/admin/updatestatus/{id}', [AdminController::class, 'updateStatus'])->name('admin.updatestatus');
Route::delete('/admin/owner/{id}', [AdminController::class, 'deleteOwner'])->name('admin.deleteOwner');
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete.user');
Route::match(['get', 'post'], 'admin/updateStatus/{id}', [AdminController::class, 'updateStatus']);
Route::post('/admin/undoReject/{id}', [AdminController::class, 'undoReject'])->name('admin.undoReject');
Route::post('/admin/deleteOwner/{id}', [AdminController::class, 'deleteOwner'])->name('admin.deleteOwner');
Route::post('/pending-owners/store', [PendingOwnerController::class, 'store'])->name('pending-owners.store');
Route::post('admin/updateStatus/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
// Undo rejection route
Route::put('/admin/undo-reject/{id}', [AdminController::class, 'undoReject'])->name('admin.undoReject');

// Delete rejected owner route
Route::delete('/admin/delete-rejected-owner/{id}', [AdminController::class, 'deleteRejectedOwner'])->name('admin.deleteRejectedOwner');
