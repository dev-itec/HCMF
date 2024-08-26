<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/denuncia', function () {
    return view('denuncia.create');
})->name('denuncia');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tenants', TenantController::class);
    /*Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/form', [FormController::class, 'index'])->name('form');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');*/

});

require __DIR__ . '/auth.php';
