<?php

use App\Http\Controllers\External\Extraprotocolar\{ClientController};

Route::get('/client', [ClientController::class, 'list']);
Route::get('/client/list-cliente/{codigo}', [ClientController::class, 'listCliente']);
Route::post('/client', [ClientController::class, 'store']);
Route::post('/client/get/register-public', [ClientController::class, 'listRegisterPublics']);
Route::post('/client/get/estado-clic', [ClientController::class, 'estadoClic']);
Route::get('/client/get/byId/{id}', [ClientController::class, 'getById']);