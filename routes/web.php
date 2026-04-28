<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\Client\ClientController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Employee\EmployeeController;
use App\Http\Controllers\Admin\Request\ClientRequestController;
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

    Route::resource('/dashboard/clients', ClientController::class)->names('admin.clients');

    Route::resource('/dashboard/employees', EmployeeController::class)->names('admin.employees');
    Route::get('/dashboard/attendance', [AdminHomePageController::class, 'attendance'])->name('admin.attendance');
    Route::get('/dashboard/payments', [AdminHomePageController::class, 'payments'])->name('admin.payments');
    Route::get('/dashboard/outdoor', [AdminHomePageController::class, 'outdoor'])->name('admin.outdoor');

    Route::get('/dashboard/requests', [ClientRequestController::class, 'index'])->name('admin.requests.index');
    Route::put('/dashboard/requests/{clientRequest}/status', [ClientRequestController::class, 'updateStatus'])->name('admin.requests.updateStatus');
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
    Route::get('/employee-dashboard/clients', [EmployeeHomePageController::class, 'clients'])->name('employee.clients.index');
    Route::get('/employee-dashboard/attendance', [EmployeeHomePageController::class, 'attendance'])->name('employee.attendance');
    Route::get('/employee-dashboard/outdoor', [EmployeeHomePageController::class, 'outdoor'])->name('employee.outdoor');
    Route::get('/employee-dashboard/requests', [EmployeeHomePageController::class, 'requests'])->name('employee.requests.index');
    Route::get('/employee-dashboard/notifications', [EmployeeHomePageController::class, 'notifications'])->name('employee.notifications');
    Route::get('/employee-dashboard/setting', [EmployeeHomePageController::class, 'setting'])->name('employee.container.setting.index');
    Route::put('/employee-dashboard/setting/{id}', [EmployeeHomePageController::class, 'updateSetting'])->name('employee.container.setting.update');
    Route::delete('/employee-dashboard/setting/session/{id}', [EmployeeHomePageController::class, 'logoutSession'])->name('employee.setting.logout-session');
});

// Client routes (only for authenticated clients)
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/client-dashboard', [\App\Http\Controllers\Client\Dashboard\ClientHomePageController::class, 'index'])->name('client.dashboard');
    Route::get('/client-dashboard/requests', [\App\Http\Controllers\Client\Dashboard\ClientHomePageController::class, 'requests'])->name('client.requests.index');
    Route::get('/client-dashboard/care-plan', [\App\Http\Controllers\Client\Dashboard\ClientHomePageController::class, 'carePlan'])->name('client.care-plan');
    Route::get('/client-dashboard/notifications', [\App\Http\Controllers\Client\Dashboard\ClientHomePageController::class, 'notifications'])->name('client.notifications');
    Route::get('/client-dashboard/setting', [\App\Http\Controllers\Client\Dashboard\ClientHomePageController::class, 'setting'])->name('client.container.setting.index');
    Route::put('/client-dashboard/setting/{id}', [\App\Http\Controllers\Client\Dashboard\ClientHomePageController::class, 'updateSetting'])->name('client.container.setting.update');
    Route::delete('/client-dashboard/setting/session/{id}', [\App\Http\Controllers\Client\Dashboard\ClientHomePageController::class, 'logoutSession'])->name('client.setting.logout-session');
});

require __DIR__ . '/auth.php';
