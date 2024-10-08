<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});
Route::middleware(['auth', 'twofactor'])->group(function () {
    Route::get('verify/resend', [App\Http\Controllers\Auth\TwoFactorController::class, 'resend'])->name('verify.resend');
    Route::resource('verify', App\Http\Controllers\Auth\TwoFactorController::class)->only(['index', 'store']);
});
Route::post('/dashboard', [App\Http\Controllers\WebsiteController::class, 'dashboard'])->middleware(['auth', 'twofactor'])->name('dashboard');
Route::get('/dashboard', [App\Http\Controllers\WebsiteController::class, 'dashboard'])->middleware(['auth', 'twofactor'])->name('dashboard');
Route::get('/addSite', [App\Http\Controllers\WebsiteController::class, 'showAddSitePage'])->middleware(['auth', 'twofactor'])->name('addSite');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
