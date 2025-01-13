<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestAmountController;
use App\Http\Controllers\AdminController;


use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Show the list of request amounts
    Route::get('/request-amounts', [RequestAmountController::class, 'index'])->name('request_amounts.index');

    // Show the form to create a new request amount
    Route::get('/request-amounts/create', [RequestAmountController::class, 'create'])->name('request_amounts.create');

    // Store a new request amount
    Route::post('/request-amounts', [RequestAmountController::class, 'store'])->name('request_amounts.store');

    // Admin route to update the status of request amounts
    Route::post('/request-amounts/{requestAmount}/status', [RequestAmountController::class, 'updateStatus'])->name('request_amounts.updateStatus')->middleware('role:admin');
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', function () {
        return 'Admin Dashboard';

    });
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.index');

    Route::get('/admin/requests', [AdminController::class, 'showRequests'])->name('admin.requests');
    Route::get('/admin/requests/{id}', [AdminController::class, 'showRequestDetails'])->name('admin.requests.details');

    Route::post('/admin/requests/update-status', [AdminController::class, 'updateRequestStatus']);

});

require __DIR__.'/auth.php';
