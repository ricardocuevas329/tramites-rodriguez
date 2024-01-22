<?php
use App\Http\Controllers\External\Extraprotocolar\{ClientController};

Route::get('/client', [ClientController::class, 'list']);
Route::post('/client', [ClientController::class, 'store']);
Route::post('/client/get/register-public', [ClientController::class, 'listRegisterPublics']);

