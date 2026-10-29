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
Route::get('/', fn () => view('welcome'));

// Dashboard
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    // ── Profile ──────────────────────────────────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Settings & Reports ────────────────────────────────────────────────────
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])
        ->middleware('permission:export')
        ->name('reports.export');

    // ── Animals ───────────────────────────────────────────────────────────────
    // create/store MUST be registered before {animal} to avoid route collision
    Route::get('animals/create', [AnimalController::class, 'create'])
        ->middleware('permission:create')->name('animals.create');
    Route::post('animals', [AnimalController::class, 'store'])
        ->middleware('permission:create')->name('animals.store');
    Route::get('animals', [AnimalController::class, 'index'])->name('animals.index');
    Route::get('animals/{animal}', [AnimalController::class, 'show'])->name('animals.show');
    Route::get('animals/{animal}/edit', [AnimalController::class, 'edit'])
        ->middleware('permission:edit')->name('animals.edit');
    Route::put('animals/{animal}', [AnimalController::class, 'update'])
        ->middleware('permission:edit')->name('animals.update');
    Route::patch('animals/{animal}', [AnimalController::class, 'update']);
    Route::delete('animals/{animal}', [AnimalController::class, 'destroy'])
        ->middleware('permission:edit')->name('animals.destroy');

    // ── Inventory ─────────────────────────────────────────────────────────────
    Route::get('inventory/create', [InventoryController::class, 'create'])
        ->middleware('permission:create')->name('inventory.create');
    Route::post('inventory', [InventoryController::class, 'store'])
        ->middleware('permission:create')->name('inventory.store');
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('inventory-movements', [InventoryMovementController::class, 'index'])
        ->name('inventory-movements.index');
    Route::get('inventory/{inventoryItem}', [InventoryController::class, 'show'])
        ->name('inventory.show');
    Route::get('inventory/{inventoryItem}/edit', [InventoryController::class, 'edit'])
        ->middleware('permission:edit')->name('inventory.edit');
    Route::put('inventory/{inventoryItem}', [InventoryController::class, 'update'])
        ->middleware('permission:edit')->name('inventory.update');
    Route::patch('inventory/{inventoryItem}', [InventoryController::class, 'update']);
    Route::get('inventory/{inventoryItem}/movements/create', [InventoryMovementController::class, 'create'])
        ->middleware('permission:create')->name('inventory.movements.create');
    Route::post('inventory/{inventoryItem}/movements', [InventoryMovementController::class, 'store'])
        ->middleware('permission:create')->name('inventory.movements.store');

    // ── Milk Productions ──────────────────────────────────────────────────────
    Route::get('milk-productions/create', [MilkProductionController::class, 'create'])
        ->middleware('permission:create')->name('milk-productions.create');
    Route::post('milk-productions', [MilkProductionController::class, 'store'])
        ->middleware('permission:create')->name('milk-productions.store');
    Route::get('milk-productions', [MilkProductionController::class, 'index'])
        ->name('milk-productions.index');
    Route::get('milk-productions/{milk_production}', [MilkProductionController::class, 'show'])
        ->name('milk-productions.show');
    Route::get('milk-productions/{milk_production}/edit', [MilkProductionController::class, 'edit'])
        ->middleware('permission:edit')->name('milk-productions.edit');
    Route::put('milk-productions/{milk_production}', [MilkProductionController::class, 'update'])
        ->middleware('permission:edit')->name('milk-productions.update');
    Route::patch('milk-productions/{milk_production}', [MilkProductionController::class, 'update']);
    Route::delete('milk-productions/{milk_production}', [MilkProductionController::class, 'destroy'])
        ->middleware('permission:edit')->name('milk-productions.destroy');

    // ── Sales ─────────────────────────────────────────────────────────────────
    Route::get('sales/create', [SaleController::class, 'create'])
        ->middleware('permission:create')->name('sales.create');
    Route::post('sales', [SaleController::class, 'store'])
        ->middleware('permission:create')->name('sales.store');
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('sales/{sale}/edit', [SaleController::class, 'edit'])
        ->middleware('permission:edit')->name('sales.edit');
    Route::put('sales/{sale}', [SaleController::class, 'update'])
        ->middleware('permission:edit')->name('sales.update');
    Route::patch('sales/{sale}', [SaleController::class, 'update']);
    Route::delete('sales/{sale}', [SaleController::class, 'destroy'])
        ->middleware('permission:edit')->name('sales.destroy');

    // ── Breedings ─────────────────────────────────────────────────────────────
    Route::get('breedings/create', [BreedingController::class, 'create'])
        ->middleware('permission:create')->name('breedings.create');
    Route::post('breedings', [BreedingController::class, 'store'])
        ->middleware('permission:create')->name('breedings.store');
    Route::get('breedings', [BreedingController::class, 'index'])->name('breedings.index');
    Route::get('breedings/{breeding}', [BreedingController::class, 'show'])->name('breedings.show');
    Route::get('breedings/{breeding}/edit', [BreedingController::class, 'edit'])
        ->middleware('permission:edit')->name('breedings.edit');
    Route::put('breedings/{breeding}', [BreedingController::class, 'update'])
        ->middleware('permission:edit')->name('breedings.update');
    Route::patch('breedings/{breeding}', [BreedingController::class, 'update']);
    Route::delete('breedings/{breeding}', [BreedingController::class, 'destroy'])
        ->middleware('permission:edit')->name('breedings.destroy');

    // ── Animal Health ─────────────────────────────────────────────────────────
    Route::get('animal-health/create', [AnimalHealthController::class, 'create'])
        ->middleware('permission:create')->name('animal-health.create');
    Route::post('animal-health', [AnimalHealthController::class, 'store'])
        ->middleware('permission:create')->name('animal-health.store');
    Route::get('animal-health', [AnimalHealthController::class, 'index'])->name('animal-health.index');
    Route::get('animal-health/{animal_health}', [AnimalHealthController::class, 'show'])
        ->name('animal-health.show');
    Route::get('animal-health/{animal_health}/edit', [AnimalHealthController::class, 'edit'])
        ->middleware('permission:edit')->name('animal-health.edit');
    Route::put('animal-health/{animal_health}', [AnimalHealthController::class, 'update'])
        ->middleware('permission:edit')->name('animal-health.update');
    Route::patch('animal-health/{animal_health}', [AnimalHealthController::class, 'update']);
    Route::delete('animal-health/{animal_health}', [AnimalHealthController::class, 'destroy'])
        ->middleware('permission:edit')->name('animal-health.destroy');

    // ── Staff Activities ──────────────────────────────────────────────────────
    Route::get('staff-activities/create', [StaffActivityController::class, 'create'])
        ->middleware('permission:create')->name('staff-activities.create');
    Route::post('staff-activities', [StaffActivityController::class, 'store'])
        ->middleware('permission:create')->name('staff-activities.store');
    Route::get('staff-activities', [StaffActivityController::class, 'index'])
        ->name('staff-activities.index');
    Route::get('staff-activities/{staff_activity}', [StaffActivityController::class, 'show'])
        ->name('staff-activities.show');
    Route::get('staff-activities/{staff_activity}/edit', [StaffActivityController::class, 'edit'])
        ->middleware('permission:edit')->name('staff-activities.edit');
    Route::put('staff-activities/{staff_activity}', [StaffActivityController::class, 'update'])
        ->middleware('permission:edit')->name('staff-activities.update');
    Route::patch('staff-activities/{staff_activity}', [StaffActivityController::class, 'update']);
    Route::delete('staff-activities/{staff_activity}', [StaffActivityController::class, 'destroy'])
        ->middleware('permission:edit')->name('staff-activities.destroy');

    // ── User Management ───────────────────────────────────────────────────────
    Route::get('user-management/create', [UserManagementController::class, 'create'])
        ->middleware('permission:manage_users')->name('user-management.create');
    Route::post('user-management', [UserManagementController::class, 'store'])
        ->middleware('permission:manage_users')->name('user-management.store');
    Route::get('user-management', [UserManagementController::class, 'index'])
        ->name('user-management.index');
    Route::get('user-management/{user_management}', [UserManagementController::class, 'show'])
        ->name('user-management.show');
    Route::get('user-management/{user_management}/edit', [UserManagementController::class, 'edit'])
        ->middleware('permission:manage_users')->name('user-management.edit');
    Route::put('user-management/{user_management}', [UserManagementController::class, 'update'])
        ->middleware('permission:manage_users')->name('user-management.update');
    Route::patch('user-management/{user_management}', [UserManagementController::class, 'update']);
    Route::delete('user-management/{user_management}', [UserManagementController::class, 'destroy'])
        ->middleware('permission:manage_users')->name('user-management.destroy');

});

// Authentication routes
require __DIR__.'/auth.php';
