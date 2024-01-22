<?php
use App\Http\Controllers\External\Extraprotocolar\PermissionTravelExternalController;


Route::post('/permission-travel', [PermissionTravelExternalController::class, 'store']);
Route::get('/permission-travel/client/find/document ', [PermissionTravelExternalController::class, 'findByDocument']);
Route::get('/permission-travel', [PermissionTravelExternalController::class, 'myRecords']);

