<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeController;
use App\Http\Controllers\Api\ResponsibiltyController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

use function GuzzleHttp\Promise\all;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Company API
Route::prefix('company')->middleware('auth:sanctum')->name('company.')->group(function () {
    Route::get('', [CompanyController::class, 'fetch'])->name('fetch');
    Route::post('', [CompanyController::class, 'create'])->name('create');
    Route::post('update/{id}', [CompanyController::class, 'update'])->name('update');
});

// Team API
Route::prefix('team')->middleware('auth:sanctum')->name('team.')->group(function () {
    Route::get('', [TeamController::class, 'fetch'])->name('fetch');
    Route::post('', [TeamController::class, 'create'])->name('create');
    Route::post('update/{id}', [TeamController::class, 'update'])->name('update');
    Route::delete('{Id}', [TeamController::class, 'destroy'])->name('delete');
});

// Employee API
Route::prefix('employee')->middleware('auth:sanctum')->name('employee.')->group(function () {
    Route::get('', [EmployeController::class, 'fetch'])->name('fetch');
    Route::post('', [EmployeController::class, 'create'])->name('create');
    Route::post('update/{id}', [EmployeController::class, 'update'])->name('update');
    Route::delete('{Id}', [EmployeController::class, 'destroy'])->name('delete');
});

// Role API
Route::prefix('role')->middleware('auth:sanctum')->name('role.')->group(function () {
    Route::get('', [RoleController::class, 'fetch'])->name('fetch');
    Route::post('', [RoleController::class, 'create'])->name('create');
    Route::post('update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('{Id}', [RoleController::class, 'destroy'])->name('delete');
});

// Responsilibity  API
Route::prefix('responsibility')->middleware('auth:sanctum')->name('responsibility.')->group(function () {
    Route::get('', [ResponsibiltyController::class, 'fetch'])->name('fetch');
    Route::post('', [ResponsibiltyController::class, 'create'])->name('create');
    Route::delete('{id}', [ResponsibiltyController::class, 'destroy'])->name('delete');
});


// Auth API
Route::name('auth.')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('user', [UserController::class, 'fetch'])->name('fetch');
    });
});