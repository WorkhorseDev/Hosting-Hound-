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
})->name('/');


 Route::get('/verifyIndex', [App\Http\Controllers\Auth\TwoFactorController::class, 'index'])->name('verifyIndex');
 Route::post('/verifyStore', [App\Http\Controllers\Auth\TwoFactorController::class, 'store'])->name('verifyStore');
 Route::get('/re-send', [App\Http\Controllers\Auth\PasswordController::class, 'reSend'])->name('re-send');


Route::middleware('auth', 'twofactor')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [App\Http\Controllers\WebsiteController::class, 'dashboard'])->name('dashboard');
    Route::get('/addSite', [App\Http\Controllers\WebsiteController::class, 'showAddSitePage'])->name('addSite');
});

require __DIR__.'/auth.php';
