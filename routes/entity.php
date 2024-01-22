<?php

use App\Http\Controllers\Entidad\{LawyerController,
    ClientController,
    CompareBlockedController,
    CompanyController,
    NotaryController,
    PersonalController,
    ClientCompanyController
};

# Comparecientes bloqueados
Route::get('/compare-blocked', [CompareBlockedController::class, 'list']);
Route::post('/compare-blocked', [CompareBlockedController::class, 'store']);
Route::put('/compare-blocked/{compareblocked} ', [CompareBlockedController::class, 'update']);
Route::get('/compare-blocked/{compareblocked} ', [CompareBlockedController::class, 'findById']);
Route::put('/compare-blocked/disabled/{compareblocked} ', [CompareBlockedController::class, 'disabled']);
Route::put('/compare-blocked/enabled/{compareblocked} ', [CompareBlockedController::class, 'enabled']);
Route::put('/compare-blocked/file/{compareblocked} ', [CompareBlockedController::class, 'clearFile']);

# Notario
Route::get('/notary', [NotaryController::class, 'list']);
Route::post('/notary', [NotaryController::class, 'store']);
Route::put('/notary/{notary} ', [NotaryController::class, 'update']);
Route::get('/notary/{notary} ', [NotaryController::class, 'findById']);
Route::put('/notary/disabled/{notary} ', [NotaryController::class, 'disabled']);
Route::put('/notary/enabled/{notary} ', [NotaryController::class, 'enabled']);

# Abogado
Route::get('/lawyer', [LawyerController::class, 'list']);
Route::post('/lawyer', [LawyerController::class, 'store']);
Route::put('/lawyer/{lawyer} ', [LawyerController::class, 'update']);
Route::get('/lawyer/{lawyer} ', [LawyerController::class, 'findById']);
Route::put('/lawyer/disabled/{lawyer} ', [LawyerController::class, 'disabled']);
Route::put('/lawyer/enabled/{lawyer} ', [LawyerController::class, 'enabled']);

# Personal
Route::get('/personal', [PersonalController::class, 'list']);
Route::post('/personal', [PersonalController::class, 'store']);
Route::put('/personal/{personal} ', [PersonalController::class, 'update']);
Route::get('/personal/{personal} ', [PersonalController::class, 'findById']);
Route::put('/personal/disabled/{personal} ', [PersonalController::class, 'disabled']);
Route::put('/personal/enabled/{personal} ', [PersonalController::class, 'enabled']);
Route::get('/personal/get/search', [PersonalController::class, 'search']);


# Clientes
Route::get('/client/search', [ClientController::class, 'search']);
Route::get('/client', [ClientController::class, 'list']);
Route::post('/client', [ClientController::class, 'store']);
Route::put('/client/{client}', [ClientController::class, 'update']);
Route::get('/client/{client}', [ClientController::class, 'findById']);
Route::get('/client/find/document', [ClientController::class, 'findByDocument']);
Route::put('/client/disabled/{client}', [ClientController::class, 'disabled']);
Route::put('/client/enabled/{client}', [ClientController::class, 'enabled']);
Route::get('/client/find/dni/{dni}', [ClientController::class, 'findByDni']);


# Empresas
Route::get('/company', [CompanyController::class, 'list']);
Route::post('/company', [CompanyController::class, 'store']);
Route::put('/company/{company} ', [CompanyController::class, 'update']);
Route::get('/company/{company} ', [CompanyController::class, 'findById']);
Route::put('/company/disabled/{company} ', [CompanyController::class, 'disabled']);
Route::put('/company/enabled/{company} ', [CompanyController::class, 'enabled']);
Route::get('/company/find/ruc/{ruc}', [CompanyController::class, 'findByRuc']);
Route::get('/company/find/document', [CompanyController::class, 'findByDocument']);



# Client-Company
Route::get('/client-company/search', [ClientCompanyController::class, 'search']);

