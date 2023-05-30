<?php

use App\Http\Controllers\Pos\ProfileController;

Route::prefix('pos')->group(function () {
    Route::get('/dashboard', function () {
        return view('pos.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
    });
});
