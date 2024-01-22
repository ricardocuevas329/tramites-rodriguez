<?php

use App\Http\Controllers\Administracion\{ActionController,
    AreaController,
    BankController,
    PropertyController,
    ConfigurationController,
    ProfessionController,
    ExchangeRateController,
    RegistrationDepositController,
    RegistrationSaleController
};

# Configuracion

Route::post('/configuration', [ConfigurationController::class, 'store']);
Route::put('/configuration/{id} ', [ConfigurationController::class, 'update']);
Route::get('/configuration/{id}', [ConfigurationController::class, 'findById']);


# Accion
Route::get('/action', [ActionController::class, 'listar']);
Route::post('/action', [ActionController::class, 'store']);
Route::put('/action/{action} ', [ActionController::class, 'update']);
Route::get('/action/{action} ', [ActionController::class, 'findById']);
Route::put('/action/disabled/{action} ', [ActionController::class, 'disabled']);
Route::put('/action/enabled/{action} ', [ActionController::class, 'enabled']);

# Registro Venta

Route::get('/registration-sale', [RegistrationSaleController::class, 'list']);
Route::post('/registration-sale', [RegistrationSaleController::class, 'store']);
Route::put('/registration-sale/{registrationSale} ', [RegistrationSaleController::class, 'update']);
Route::get('/registration-sale/{id} ', [RegistrationSaleController::class, 'findById']);
Route::put('/registration-sale/disabled/{registrationSale} ', [RegistrationSaleController::class, 'disabled']);
Route::put('/registration-sale/enabled/{registrationSale} ', [RegistrationSaleController::class, 'enabled']);
Route::delete('/registration-sale/document/{id_document}', [RegistrationSaleController::class, 'delete_document']);

# Registro Deposito
Route::get('/register-deposit', [RegistrationDepositController::class, 'list']);
Route::post('/register-deposit', [RegistrationDepositController::class, 'store']);
Route::put('/register-deposit/{registerdeposit} ', [RegistrationDepositController::class, 'update']);
Route::get('/register-deposit/{id} ', [RegistrationDepositController::class, 'findById']);
Route::put('/register-deposit/disabled/{registerdeposit} ', [RegistrationDepositController::class, 'disabled']);
Route::put('/register-deposit/enabled/{registerdeposit} ', [RegistrationDepositController::class, 'enabled']);
Route::put('/register-deposit/aprove/{id}', [RegistrationDepositController::class, 'aprove']);
Route::delete('/register-deposit/document/{id_document}', [RegistrationDepositController::class, 'delete_document']);


# Areas
Route::get('/area', [AreaController::class, 'list']);
Route::post('/area', [AreaController::class, 'store']);
Route::put('/area/{area} ', [AreaController::class, 'update']);
Route::get('/area/{area} ', [AreaController::class, 'findById']);
Route::put('/area/disabled/{area} ', [AreaController::class, 'disabled']);
Route::put('/area/enabled/{area} ', [AreaController::class, 'enabled']);

# Banco
Route::get('/bank', [BankController::class, 'list']);
Route::post('/bank', [BankController::class, 'store']);
Route::put('/bank/{bank} ', [BankController::class, 'update']);
Route::get('/bank/{bank} ', [BankController::class, 'findById']);
Route::put('/bank/disabled/{bank} ', [BankController::class, 'disabled']);
Route::put('/bank/enabled/{bank} ', [BankController::class, 'enabled']);
Route::get('/bank/list/all', [BankController::class, 'all']);


# Bienes
Route::get('/property', [PropertyController::class, 'list']);
Route::post('/property', [PropertyController::class, 'store']);
Route::put('/property/{id} ', [PropertyController::class, 'update']);
Route::get('/property/{id} ', [PropertyController::class, 'findById']);
Route::put('/property/disabled/{id} ', [PropertyController::class, 'disabled']);
Route::put('/property/enabled/{id} ', [PropertyController::class, 'enabled']);

# Tipo Cambio
Route::get('/exchange-rate', [ExchangeRateController::class, 'list']);
Route::post('/exchange-rate', [ExchangeRateController::class, 'store']);
Route::put('/exchange-rate/{id} ', [ExchangeRateController::class, 'update']);
Route::get('/exchange-rate/{id} ', [ExchangeRateController::class, 'findById']);
Route::put('/exchange-rate/disabled/{id} ', [ExchangeRateController::class, 'disabled']);
Route::put('/exchange-rate/enabled/{id} ', [ExchangeRateController::class, 'enabled']);

# Profesion
Route::get('/profession', [ProfessionController::class, 'list']);
Route::post('/profession', [ProfessionController::class, 'store']);
Route::put('/profession/{id} ', [ProfessionController::class, 'update']);
Route::get('/profession/{id} ', [ProfessionController::class, 'findById']);
Route::put('/profession/disabled/{id} ', [ProfessionController::class, 'disabled']);
Route::put('/profession/enabled/{id} ', [ProfessionController::class, 'enabled']);
