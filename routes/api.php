<?php

use App\Http\Controllers\Administracion\{ConfigurationController};
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('external')->group(function () {
    require __DIR__ . '/external.php';
});


# configuracion
Route::get('/configuration', [ConfigurationController::class, 'list']);

# login
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [AuthController::class, 'authenticated']);
    Route::post('/change-password', [AuthController::class, 'changepassswordDefault']);

    //Route::middleware(['resetPasswordDefault'])->group(function () {

       

        Route::prefix('')->group(function () {
            require __DIR__ . '/extraprotocol.php';
        });

        Route::prefix('')->group(function () {
            require __DIR__ . '/maintenance.php';
        });

        Route::prefix('')->group(function () {
            require __DIR__ . '/entity.php';
        });

        Route::prefix('')->group(function () {
            require __DIR__ . '/administration.php';
        });

        Route::prefix('')->group(function () {
            require __DIR__ . '/protocol.php';
        });

        Route::post('/onLogout', [AuthController::class, 'onLogout']);

    //});
});
