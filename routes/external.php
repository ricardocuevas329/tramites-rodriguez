<?php

use App\Http\Controllers\External\Mantenimiento\{NationalityController, DocumentTypeController, UbigeoController};
use App\Http\Controllers\External\Auth\AuthController;
use App\Http\Controllers\External\Protocolar\KardexController;

Route::post('/kardex-consulta/get/searchKardex', [KardexController::class, 'searchKardex']);
Route::post('/kardex-consulta/get/searchCodigo', [KardexController::class, 'searchCodigo']);

Route::post('/kardex-consulta/get/participants', [KardexController::class, 'listParticipants']);

Route::get('/tipo-documento-activos', [DocumentTypeController::class, 'actives']);

Route::post('/auth/register ', [AuthController::class, 'register']);
Route::post('/auth/login ', [AuthController::class, 'login']);


//Route::middleware('auth:sanctum-client')->group(function () {
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/auth/user ', [AuthController::class, 'authenticated']);
    Route::post('/auth/logout ', [AuthController::class, 'logout']);
    Route::get('/nacionalidad-all', [NationalityController::class, 'listarAll']);
    Route::get('/ubigeo/search-ubigeo', [UbigeoController::class, 'searchUbigeo']);

    Route::prefix('')->group(function () {
        require __DIR__ . '/external/travel-permission.php';
        require __DIR__ . '/external/client.php';
        require __DIR__ . '/external/kardex.php';
    });


    //Route::get('/tipo-documento-activos', [DocumentTypeController::class, 'activos']);
});
