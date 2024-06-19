<?php

use App\Http\Controllers\Protocolar\{KardexController, TipoKardexController, TramiteController};

# Kardex

Route::get('/kardex', [KardexController::class, 'list']);
Route::post('/kardex', [KardexController::class, 'store']);
Route::put('/kardex/{kardex}', [KardexController::class, 'update']);
Route::get('/kardex/{kardex}', [KardexController::class, 'findById']);
Route::put('/kardex/disabled/{kardex}', [KardexController::class, 'disabled']);
Route::put('/kardex/enabled/{kardex}', [KardexController::class, 'enabled']);
Route::get('/kardex/generateDocument/{kardex}', [KardexController::class, 'generateDocument']);
Route::delete('/kardex/document/{id_document}', [KardexController::class, 'delete_document']);
Route::get('/kardex/generateDocumentExcel/{kardex}', [KardexController::class, 'generateExcel']);
Route::get('/kardex/generateDocumentPDF/{kardex}', [KardexController::class, 'generatePDF']);
# TipoKardex
Route::get('/tipo-kardex/actives', [TipoKardexController::class, 'listActives']);

# Tramite
Route::get('/tramite', [TramiteController::class, 'list']);
Route::post('/tramite/observation-external', [TramiteController::class, 'saveObservationExternal']);
Route::post('/tramite/observation-internal', [TramiteController::class, 'saveObservationInternal']);
Route::get('/tramite/getAllObservationById/{id}', [TramiteController::class, 'getAllObservationById']);
Route::get('/tramite/get/byId/{id}', [TramiteController::class, 'getById']);
