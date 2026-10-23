<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AnimalHealthController;
use App\Http\Controllers\BreedingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\MilkProductionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffActivityController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Animal Management
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('animals', AnimalController::class);
    Route::resource('inventory', InventoryController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update'])
        ->parameters(['inventory' => 'inventoryItem']);
    Route::get('inventory-movements', [InventoryMovementController::class, 'index'])
        ->name('inventory-movements.index');
    Route::get('inventory/{inventoryItem}/movements/create', [InventoryMovementController::class, 'create'])
        ->name('inventory.movements.create');
    Route::post('inventory/{inventoryItem}/movements', [InventoryMovementController::class, 'store'])
        ->name('inventory.movements.store');
});

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])
        ->name('reports.export');
    Route::middleware('auth')->group(function () {

        Route::resource('staff-activities', StaffActivityController::class);

        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');

    });
    Route::get('/user-management', [UserManagementController::class, 'index'])
        ->middleware('auth')
        ->name('user-management.index');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::resource('breedings', BreedingController::class);
    Route::resource('milk-productions', MilkProductionController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('animal-health', AnimalHealthController::class);
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';