<?php

use App\Http\Controllers\Pos\HRMS\PositionsController;
use App\Http\Controllers\Pos\HRMS\EmployeesController;

Route::prefix('pos/dashboard/hrms')->group(function () {
    Route::middleware('auth')->group(function () {
        // Position routes
        Route::get('/positions', [PositionsController::class, 'index'])->name('pos.hrms.positions');
        Route::get('/positions/dt', [PositionsController::class, 'show'])->name('pos.hrms.positions.table');
        Route::post('/positions/add', [PositionsController::class, 'store'])->name('pos.hrms.positions.add');
        Route::get('/positions/show', [PositionsController::class, 'edit'])->name('pos.hrms.positions.show');
        Route::post('/positions/delete', [PositionsController::class, 'destroy'])->name('pos.hrms.positions.delete');
        Route::post('/positions/update', [PositionsController::class, 'update'])->name('pos.hrms.positions.update');

        // Employee routes
        Route::get('/employees', [EmployeesController::class, 'index'])->name('pos.hrms.employees');
        Route::get('/employees/dt', [EmployeesController::class, 'show'])->name('pos.hrms.employees.table');
        Route::post('/employees/add', [EmployeesController::class, 'store'])->name('pos.hrms.employees.add');
        Route::get('/employees/show', [EmployeesController::class, 'edit'])->name('pos.hrms.employees.show');
        Route::post('/employees/delete', [EmployeesController::class, 'destroy'])->name('pos.hrms.employees.delete');
        Route::post('/employees/update', [EmployeesController::class, 'update'])->name('pos.hrms.employees.update');
    });
});
