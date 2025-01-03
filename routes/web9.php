<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LifestyleController;
use App\Http\Controllers\TravelMemoryController;

// Travel Memory routes
Route::middleware('auth')->group(function () {
    Route::get('/travel-memories', [TravelMemoryController::class, 'index'])->name('travel-memories.index');
    Route::get('/travel-memories/create', [TravelMemoryController::class, 'create'])->name('travel-memories.create');
    Route::post('/travel-memories', [TravelMemoryController::class, 'store'])->name('travel-memories.store');
    Route::get('/travel-memories/{travelMemory}', [TravelMemoryController::class, 'show'])->name('travel-memories.show');
    Route::get('/travel-memories/{travelMemory}/edit', [TravelMemoryController::class, 'edit'])->name('travel-memories.edit');
    Route::put('/travel-memories/{travelMemory}', [TravelMemoryController::class, 'update'])->name('travel-memories.update');
    Route::delete('/travel-memories/{travelMemory}', [TravelMemoryController::class, 'destroy'])->name('travel-memories.destroy');
});

// Redirect root to the login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Defines resource routes for the LifestyleController
Route::resource('lifestyles', LifestyleController::class);

// Authentication routes (login, registration, logout)
Auth::routes();

// File routes
Route::middleware('auth')->group(function () {
    Route::post('/files', [FileController::class, 'store'])->name('files.store'); // File upload
    Route::patch('/files/{file}', [FileController::class, 'update'])->name('files.update'); // File update
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy'); // File delete
});

// Portfolio and other authenticated routes
Route::middleware('auth')->group(function () {
    // Portfolio routes
    Route::resource('portfolio', PortfolioController::class);

    // Portfolio index route
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

    // Search route for portfolios
    Route::get('/portfolio/search', [PortfolioController::class, 'search'])->name('portfolio.search');

    // Comment routes
    Route::post('/portfolio/{portfolio}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/copy-avatars', [ProfileController::class, 'copyAvatars']);

    // Redirect to home after login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Travel route
    Route::get('/travel', [PortfolioController::class, 'travelIndex'])->name('travel.index');

    // Lifestyle route
    Route::get('/lifestyle', [PortfolioController::class, 'lifestyleIndex'])->name('lifestyle.index');
});



