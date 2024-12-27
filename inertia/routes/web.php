<?php

use App\Http\Controllers\DeferredPropsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PartialReloadController;
use Illuminate\Support\Facades\Session;


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
    Route::get('/partial-reload', [PartialReloadController::class, 'index'])->name('partial-reload');
    Route::post('/partial-reload/reload', [PartialReloadController::class, 'increment']);
    Route::post('/partial-reload/users', [PartialReloadController::class, 'reload']);
    Route::get('/deferred-props', [DeferredPropsController::class, 'index'])->name('deferred-props');
});


Route::post('/test', function () {
    Session::flash('toast', 'Form submitted successfully!');
    return redirect()->route('dashboard');
});

require __DIR__.'/auth.php';
