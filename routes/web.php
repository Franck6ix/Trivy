<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeneratingController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NouveauVoyageController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// ── Pages publiques ──
Route::get('/', WelcomeController::class)->name('home');

// Auth Livewire
Route::middleware('guest')->group(function () {
    Route::get('/register', \App\Livewire\Auth\RegisterForm::class)->name('register');
      Route::post('/register', [RegisterController::class, 'register'] )->name('register');
    Route::get('/login',    \App\Livewire\Auth\LoginForm::class)->name('login');
});

// ── Pages protégées (user connecté) ──
Route::middleware('auth')->group(function () {
    Route::get('/onboarding', \App\Livewire\Onboarding\OnboardingWizard::class)->name('onboarding');
    Route::get('/generating', GeneratingController::class)->name('ai-generation');
    Route::get('/dashboard',  DashboardController::class)->name('dashboard');
    Route::get('/valise',     \App\Livewire\Valise\PackingList::class)->name('valise');
    Route::get('/assistant',  \App\Livewire\Assistant\Chat::class)->name('assistant');
    Route::get('/profil',     ProfilController::class)->name('profil');
    Route::post('/nouveau-voyage', NouveauVoyageController::class)->name('nouveau-voyage');
    Route::post('/logout',    LogoutController::class)->name('logout');
});
