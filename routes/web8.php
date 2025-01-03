<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelMemoryController;
use App\Http\Controllers\LifestyleController;
// Redirect root to the login page
Route::get('/', function () {
    return redirect()->route('login');
});
// Define authentication routes (login, registration, logout)
Auth::routes();
// Travel Memory routes
Route::middleware('auth')->group(function () {
    Route::get('/travel-memories', [TravelMemoryController::class, 'index'])->name('travel-memories.index');
    Route::get('/travel-memories/create', [TravelMemoryController::class, 'create'])->name('travel-memories.create');
    Route::post('/travel-memories/store', [TravelMemoryController::class, 'store'])->name('travel-memories.store');
    Route::get('/travel-memories/{travelMemory}/edit', [TravelMemoryController::class, 'edit'])->name('travel-memories.edit');
    Route::patch('/travel-memories/{travelMemory}', [TravelMemoryController::class, 'update'])->name('travel-memories.update');
    Route::delete('/travel-memories/{travelMemory}', [TravelMemoryController::class, 'destroy'])->name('travel-memories.destroy');
});
// File routes
Route::middleware('auth')->group(function () {
    Route::post('/files', [FileController::class, 'store'])->name('files.store'); // File upload
    Route::patch('/files/{file}', [FileController::class, 'update'])->name('files.update'); // File update
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy'); // File delete
});
// Portfolio and related authenticated routes
Route::middleware('auth')->group(function () {
    // Portfolio routes
    Route::resource('portfolio', PortfolioController::class);
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
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
});
// Travel and Lifestyle routes
Route::middleware('auth')->group(function () {
    // Travel route
    Route::get('/travel', [PortfolioController::class, 'travelIndex'])->name('travel.index'); 
    // Lifestyle routes
    Route::get('/lifestyles', [LifestyleController::class, 'index'])->name('lifestyles.index');
    Route::get('/lifestyles/create', [LifestyleController::class, 'create'])->name('lifestyles.create');
    Route::post('/lifestyles', [LifestyleController::class, 'store'])->name('lifestyles.store');
    Route::get('/lifestyles/{lifestyle}', [LifestyleController::class, 'show'])->name('lifestyles.show');
    Route::get('/lifestyles/{lifestyle}/edit', [LifestyleController::class, 'edit'])->name('lifestyles.edit');
    Route::put('/lifestyles/{lifestyle}', [LifestyleController::class, 'update'])->name('lifestyles.update');
    Route::delete('/lifestyles/{lifestyle}', [LifestyleController::class, 'destroy'])->name('lifestyles.destroy');
});
