<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LifestyleController;
use App\Http\Controllers\TravelMemoryController;

// Redirect root to the login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Auth::routes();

// Travel Memory routes
Route::middleware('auth')->group(function () {
    // Index: List all travel memories
    Route::get('/travel-memories', [TravelMemoryController::class, 'index'])->name('travel-memories.index');
    
    // Create: Show the form to create a new travel memory
    Route::get('/travel-memories/create', [TravelMemoryController::class, 'create'])->name('travel-memories.create');
    
    // Store: Save a new travel memory
    Route::post('/travel-memories', [TravelMemoryController::class, 'store'])->name('travel-memories.store');
    
    // Show: Display a specific travel memory
    Route::get('/travel-memories/{travelMemory}', [TravelMemoryController::class, 'show'])->name('travel-memories.show');
    
    // Edit: Show the form to edit a specific travel memory
    Route::get('/travel-memories/{travelMemory}/edit', [TravelMemoryController::class, 'edit'])->name('travel-memories.edit');
    
    // Update: Save updates to a specific travel memory
    Route::put('/travel-memories/{travelMemory}', [TravelMemoryController::class, 'update'])->name('travel-memories.update');
    
    // Delete: Remove a specific travel memory
    Route::delete('/travel-memories/{travelMemory}', [TravelMemoryController::class, 'destroy'])->name('travel-memories.destroy');

    // Show Media for Deletion: Display photos and videos for selection
    Route::get('/travel-memories/{travelMemory}/media-delete', [TravelMemoryController::class, 'showMediaForDeletion'])->name('travel-memories.showMediaForDeletion');

    // Delete Media: Process deletion of selected photos/videos
    Route::post('/travel-memories/{travelMemory}/media-delete', [TravelMemoryController::class, 'deleteMedia'])->name('travel-memories.deleteMedia');

    // Add Media: Process the addition of selected photos/videos
    Route::get('/travel-memories/{travelMemory}/add-media', [TravelMemoryController::class, 'addMedia'])->name('travel-memories.addMedia');
    Route::post('/travel-memories/{travelMemory}/add-media', [TravelMemoryController::class, 'storeMedia'])->name('travel-memories.storeMedia');
        

});

// File Management routes
Route::middleware('auth')->group(function () {
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::patch('/files/{file}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
});

// Lifestyle routes
Route::resource('lifestyles', LifestyleController::class)->middleware('auth');

// Portfolio routes
Route::middleware('auth')->group(function () {
    Route::resource('portfolio', PortfolioController::class);

    // Portfolio index
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

    // Portfolio search
    Route::get('/portfolio/search', [PortfolioController::class, 'search'])->name('portfolio.search');
    
    // Comments on portfolio
    Route::post('/portfolio/{portfolio}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/copy-avatars', [ProfileController::class, 'copyAvatars']);
});

// Home page after login
Route::middleware('auth')->get('/home', [HomeController::class, 'index'])->name('home');

// Redirects for specific categories
Route::middleware('auth')->group(function () {
    Route::get('/travel', [PortfolioController::class, 'travelIndex'])->name('travel.index');
    Route::get('/lifestyle', [PortfolioController::class, 'lifestyleIndex'])->name('lifestyle.index');
});

