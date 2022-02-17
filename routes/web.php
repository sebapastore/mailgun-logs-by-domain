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

// Users

Route::resource('users', \App\Http\Controllers\UserController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::put('users/{user}/update_password', [\App\Http\Controllers\UserController::class, 'updatePassword'])
    ->middleware(['auth:sanctum', 'verified'])->name('users.update-password');

Route::get('/domains', [DomainController::class, 'index'])
    ->middleware(['auth:sanctum', 'verified'])->name('domains.index');
