<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FileUploadController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'toast' => session('toast', null),
    ]);    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/file-upload', function () {
    return Inertia::render('FileUpload');
})->middleware(['auth', 'verified'])->name('fileupload');
Route::post('/file-upload', [FileUploadController::class, 'store'])->name('file.upload');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('test', function(){
    return redirect()->back()->with('toast', 'Toast Endpoint!');
});

require __DIR__.'/auth.php';
