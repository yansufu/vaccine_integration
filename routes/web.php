<?php
use App\Http\Controllers\Home;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\forgotPasswordController;

use App\Models\Children;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/new', [UserController::class, 'new'])->name('new');
Route::get('/new/{id}', [UserController::class, 'showNews'])->name('news.show');
Route::get('/catalog', [UserController::class, 'catalog'])->name('catalog');
Route::get('/check-health-status', [UserController::class, 'results'])->name('check.results')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');

Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
// Show the reset password form (user clicks from email)
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');

// Handle the form submission to reset password
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');

