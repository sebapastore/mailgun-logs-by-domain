<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DomainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

/*
 * Admin Routes
 * todo: middleware for admin and customer
 * - Users
 * - Domains
 * */

Route::middleware('admin')->group(function() {

    // Users

    Route::resource('users', \App\Http\Controllers\UserController::class)
        ->middleware(['auth:sanctum', 'verified']);

    Route::put('users/{user}/update_password', [\App\Http\Controllers\UserController::class, 'updatePassword'])
        ->middleware(['auth:sanctum', 'verified'])->name('users.update-password');

    // Domains

    Route::resource('domains', \App\Http\Controllers\DomainController::class)
        ->middleware(['auth:sanctum', 'verified']);

    Route::get('user-domains/{user}', [\App\Http\Controllers\UserDomainController::class, 'index'])
        ->middleware(['auth:sanctum', 'verified'])->name('user-domain.index');

    Route::post('user/{user}/domain/{domain}', [\App\Http\Controllers\UserDomainController::class, 'store'])
        ->middleware(['auth:sanctum', 'verified'])->name('user-domain.store');

    Route::delete('user/{user}/domain/{domain}', [\App\Http\Controllers\UserDomainController::class, 'destroy'])
        ->middleware(['auth:sanctum', 'verified'])->name('user-domain.destroy');

    Route::get('maillog', [\App\Http\Controllers\MailLogController::class, 'index'])
        ->middleware(['auth:sanctum', 'verified'])->name('mail-log.index');
});

