<?php
use App\Http\Controllers\External\Protocolar\KardexController;

Route::get('/kardex/get/tipo-kardex/actives', [ KardexController::class, 'listActives']);
Route::post('/kardex/save/asignation', [ KardexController::class, 'saveAsignation']);
Route::post('/kardex/get/participants', [ KardexController::class, 'listParticipants']);
Route::post('/kardex/save/documents', [ KardexController::class, 'saveDocument']);



