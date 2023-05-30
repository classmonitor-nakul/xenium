<?php

use App\Http\Controllers\Pos\CRM\CustomersController;
use App\Http\Controllers\Pos\CRM\DealersController;
use App\Http\Controllers\Pos\CRM\LeadsController;
use App\Http\Controllers\Pos\CRM\Leads_historyController;

Route::prefix('pos/dashboard/crm')->group(function () {
    Route::middleware('auth')->group(function () {
        // Customer routes
        Route::get('/customers', [CustomersController::class, 'index'])->name('pos.crm.customers');
        Route::get('/customers/dt', [CustomersController::class, 'show'])->name('pos.crm.customers.table');
        Route::post('/customers/add', [CustomersController::class, 'store'])->name('pos.crm.customers.add');
        Route::get('/customers/show', [CustomersController::class, 'edit'])->name('pos.crm.customers.show');
        Route::post('/customers/delete', [CustomersController::class, 'destroy'])->name('pos.crm.customers.delete');
        Route::post('/customers/update', [CustomersController::class, 'update'])->name('pos.crm.customers.update');

        //Dealer routes
        Route::get('/dealers', [DealersController::class, 'index'])->name('pos.crm.dealers');
        Route::get('/dealers/dt', [DealersController::class, 'show'])->name('pos.crm.dealers.table');
        Route::post('/dealers/add', [DealersController::class, 'store'])->name('pos.crm.dealers.add');
        Route::get('/dealers/show', [DealersController::class, 'edit'])->name('pos.crm.dealers.show');
        Route::post('/dealers/delete', [DealersController::class, 'destroy'])->name('pos.crm.dealers.delete');
        Route::post('/dealers/update', [DealersController::class, 'update'])->name('pos.crm.dealers.update');

        //Lead routes
        Route::get('/leads', [LeadsController::class, 'index'])->name('pos.crm.leads');
        Route::get('/leads/dt', [LeadsController::class, 'show'])->name('pos.crm.leads.table');
        Route::post('/leads/add', [LeadsController::class, 'store'])->name('pos.crm.leads.add');
        Route::get('/leads/show', [LeadsController::class, 'edit'])->name('pos.crm.leads.show');
        Route::post('/leads/delete', [LeadsController::class, 'destroy'])->name('pos.crm.leads.delete');
        Route::post('/leads/update', [LeadsController::class, 'update'])->name('pos.crm.leads.update');

        //Lead History routes
        Route::get('/leads_history', [Leads_historyController::class, 'index'])->name('pos.crm.leads_history');
        Route::get('/leads_history/dt', [Leads_historyController::class, 'show'])->name('pos.crm.leads_history.table');
        Route::post('/leads_history/add', [Leads_historyController::class, 'store'])->name('pos.crm.leads_history.add');
        Route::get('/leads_history/show', [Leads_historyController::class, 'edit'])->name('pos.crm.leads_history.show');
        Route::post('/leads_history/delete', [Leads_historyController::class, 'destroy'])->name('pos.crm.leads_history.delete');
        Route::post('/leads_history/update', [Leads_historyController::class, 'update'])->name('pos.crm.leads_history.update');
    });
});
