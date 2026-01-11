<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;

// FRONTEND/ROUTING CHANGE: public landing page using Blade home view
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/places', [CustomerController::class, 'listPlaces'])->name('customer.places');
    Route::get('/places/{id}', [CustomerController::class, 'showPlace'])->name('customer.places.show');

    Route::get('/reservations/confirm', [CustomerController::class, 'confirmReservation'])->name('customer.reservations.confirm');
    Route::post('/reservations', [CustomerController::class, 'storeReservation'])->name('customer.reservations.store');
    Route::put('/reservations/{id}', [CustomerController::class, 'updateReservation'])->name('customer.reservations.update');
    Route::delete('/reservations/{id}', [CustomerController::class, 'cancelReservation'])->name('customer.reservations.cancel');
});

Route::middleware(['auth', 'role:owner'])->prefix('owner')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');

    Route::get('/places/create', [OwnerController::class, 'createPlace'])->name('owner.places.create');
    Route::post('/places', [OwnerController::class, 'storePlace'])->name('owner.places.store');
    Route::get('/places/{id}/edit', [OwnerController::class, 'editPlace'])->name('owner.places.edit');
    Route::put('/places/{id}', [OwnerController::class, 'updatePlace'])->name('owner.places.update');
    Route::delete('/places/{id}', [OwnerController::class, 'deletePlace'])->name('owner.places.delete');

    Route::post('/reservations/{id}/approve', [OwnerController::class, 'approveReservation'])->name('owner.reservations.approve');
    Route::post('/reservations/{id}/decline', [OwnerController::class, 'declineReservation'])->name('owner.reservations.decline');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Owners routes
    Route::get('/owners', [AdminController::class, 'indexOwners'])->name('admin.owners.index');
    Route::get('/owners/create', [AdminController::class, 'createOwner'])->name('admin.owners.create');
    Route::post('/owners', [AdminController::class, 'storeOwner'])->name('admin.owners.store');
    Route::delete('/owners/{id}', [AdminController::class, 'deleteOwner'])->name('admin.owners.delete');

    // Customers routes
    Route::get('/customers', [AdminController::class, 'indexCustomers'])->name('admin.customers.index');
    Route::get('/customers/create', [AdminController::class, 'createCustomer'])->name('admin.customers.create');
    Route::post('/customers', [AdminController::class, 'storeCustomer'])->name('admin.customers.store');
    Route::delete('/customers/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.customers.delete');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

