<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::put('/{permission}', [PermissionController::class, 'update']);
    Route::get('/{permission}/delete', [PermissionController::class, 'destroy']);
});

Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/', [RoleController::class, 'store']);
    Route::put('/{roles}', [RoleController::class, 'update']);
    Route::get('/{roles}/delete', [RoleController::class, 'destroy']);
});
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{users}', [UserController::class, 'update']);
    Route::get('/{users}/delete', [UserController::class, 'destroy']);
    Route::get('/{users}/reset-password', [UserController::class, 'resetPassword']);
});

Route::get('/logs', [LogController::class, '__invoke']);

Route::prefix('presence')->group(function () {
    Route::get('/in', function () {
        $title = 'Presence In';
        return view('presence_in.index', compact('title'));
    });
});
