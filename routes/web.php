<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Dashboard\AdminHomePageController;

// Employee Controllers
use App\Http\Controllers\Employee\Dashboard\EmployeeHomePageController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Root route - Login Page
Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Admin routes (only for authenticated admins)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminHomePageController::class, 'index'])->name('admin.dashboard');

    Route::get('/dashboard/clients', [AdminHomePageController::class, 'clients'])->name('admin.clients');
    Route::get('/dashboard/employees', [AdminHomePageController::class, 'employees'])->name('admin.employees');
    Route::get('/dashboard/attendance', [AdminHomePageController::class, 'attendance'])->name('admin.attendance');
    Route::get('/dashboard/payments', [AdminHomePageController::class, 'payments'])->name('admin.payments');
    Route::get('/dashboard/outdoor', [AdminHomePageController::class, 'outdoor'])->name('admin.outdoor');
    Route::get('/dashboard/requests', [AdminHomePageController::class, 'requests'])->name('admin.requests');
    Route::get('/dashboard/complaints', [AdminHomePageController::class, 'complaints'])->name('admin.complaints');
    Route::get('/dashboard/notifications', [AdminHomePageController::class, 'notifications'])->name('admin.notifications');
    Route::get('/dashboard/reports', [AdminHomePageController::class, 'reports'])->name('admin.reports');

    // Setting routes
    Route::get('/dashboard/setting', [SettingController::class, 'index'])->name('admin.container.setting.index');
    Route::put('/dashboard/setting/{id}', [SettingController::class, 'update'])->name('admin.container.setting.update');
    Route::delete('/dashboard/setting/session/{id}', [SettingController::class, 'logoutSession'])->name('admin.setting.logout-session');
});

// Employee routes (only for authenticated employees)
Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/employee-dashboard', [EmployeeHomePageController::class, 'index'])->name('employee.dashboard');
});

require __DIR__ . '/auth.php';
