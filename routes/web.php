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
 Route::get('/verifyResend', [App\Http\Controllers\Auth\TwoFactorController::class, 'resend'])->name('verifyResend');
 Route::get('/re-send', [App\Http\Controllers\Auth\PasswordController::class, 'reSend'])->name('re-send');


Route::middleware('auth', 'twofactor')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [App\Http\Controllers\WebsiteController::class, 'dashboard'])->name('dashboard');
    Route::get('/billing', [App\Http\Controllers\WebsiteController::class, 'billing'])->name('billing');
    Route::get('/addSite', [App\Http\Controllers\WebsiteController::class, 'showAddSitePage'])->name('addSite');
    Route::post('/saveSite', [App\Http\Controllers\WebsiteController::class, 'saveSite'])->name('saveSite');
    Route::post('/editSite', [App\Http\Controllers\WebsiteController::class, 'editSite'])->name('editSite');
    Route::post('/deleteSites', [App\Http\Controllers\WebsiteController::class, 'deleteSites'])->name('deleteSites');
    Route::get('/siteDetail/{id}', [App\Http\Controllers\WebsiteController::class, 'showSiteDetailPage'])->name('siteDetail');
    Route::get('/editSiteView/{id}', [App\Http\Controllers\WebsiteController::class, 'editSiteView'])->name('editSiteView');
    Route::post('/share', [App\Http\Controllers\WebsiteController::class, 'shareSites'])->name('share');
    Route::post('/unShareSites', [App\Http\Controllers\WebsiteController::class, 'unShareSites'])->name('unShareSites');
    Route::get('/hostDetail/{key}/{id}', [App\Http\Controllers\WebsiteController::class, 'showHostDetailPage'])->name('hostDetail');
});

require __DIR__.'/auth.php';













