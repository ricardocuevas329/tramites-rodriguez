<?php

use App\Http\Controllers\Mantenimiento\{BankDepositController,
    ChargeController,
    ChargePublicController,
    DepartamentController,
    DistrictController,
    DocumentSaleController,
    EstateController,
    PaymentModeController,
    NationalityController,
    CountryController,
    PermissionController,
    ProvinceController,
    RequirementController,
    RoleController,
    ServicieController,
    TypeComparisonController,
    TypeDocumentController,
    UbigeoController,
    UnitController,
    RegistryZoneController,
    ConditionController
};

# Zona Registral
Route::get('/registry-zone', [RegistryZoneController::class, 'list']);
Route::post('/registry-zone', [RegistryZoneController::class, 'store']);
Route::put('/registry-zone/{registryzone} ', [RegistryZoneController::class, 'update']);
Route::get('/registry-zone/{registryzone} ', [RegistryZoneController::class, 'findById']);
Route::put('/registry-zone/disabled/{registryzone} ', [RegistryZoneController::class, 'disabled']);
Route::put('/registry-zone/enabled/{registryzone} ', [RegistryZoneController::class, 'enabled']);

# Role
Route::get('/role', [RoleController::class, 'list']);
Route::post('/role', [RoleController::class, 'store']);
Route::put('/role/{role} ', [RoleController::class, 'update']);
Route::get('/role/{role} ', [RoleController::class, 'findById']);

# Permission
Route::get('/permission', [PermissionController::class, 'list']);
Route::post('/permission', [PermissionController::class, 'store']);
Route::put('/permission/{permission} ', [PermissionController::class, 'update']);
Route::get('/permission/{permission} ', [PermissionController::class, 'findById']);

# Requisito
Route::get('/requisito', [RequirementController::class, 'list']);
Route::post('/requisito', [RequirementController::class, 'store']);
Route::put('/requisito/{requisito} ', [RequirementController::class, 'update']);
Route::get('/requisito/{requisito} ', [RequirementController::class, 'findById']);
Route::put('/requisito/disabled/{requisito} ', [RequirementController::class, 'disabled']);
Route::put('/requisito/enabled/{requisito} ', [RequirementController::class, 'enabled']);

# Tipo Compareciente
Route::get('/tipo-compareciente', [TypeComparisonController::class, 'list']);
Route::post('/tipo-compareciente', [TypeComparisonController::class, 'store']);
Route::put('/tipo-compareciente/{tipocompareciente} ', [TypeComparisonController::class, 'update']);
Route::get('/tipo-compareciente/{tipocompareciente} ', [TypeComparisonController::class, 'findById']);
Route::put('/tipo-compareciente/disabled/{tipocompareciente} ', [TypeComparisonController::class, 'disabled']);
Route::put('/tipo-compareciente/enabled/{tipocompareciente} ', [TypeComparisonController::class, 'enabled']);

# Servicio
Route::get('/service', [ServicieController::class, 'list']);
Route::post('/service', [ServicieController::class, 'store']);
Route::put('/service/{service} ', [ServicieController::class, 'update']);
Route::get('/service/{service} ', [ServicieController::class, 'findById']);
Route::put('/service/disabled/{service} ', [ServicieController::class, 'disabled']);
Route::put('/service/enabled/{service} ', [ServicieController::class, 'enabled']);

# Banco Deposito
Route::get('/banco-deposito', [BankDepositController::class, 'listar']);
Route::post('/banco-deposito', [BankDepositController::class, 'store']);
Route::put('/banco-deposito/{bancodeposito} ', [BankDepositController::class, 'update']);
Route::get('/banco-deposito/{bancodeposito} ', [BankDepositController::class, 'findById']);
Route::put('/banco-deposito/disabled/{bancodeposito} ', [BankDepositController::class, 'disabled']);
Route::put('/banco-deposito/enabled/{bancodeposito} ', [BankDepositController::class, 'enabled']);


# Unidad
Route::get('/unidad', [UnitController::class, 'list']);
Route::post('/unidad', [UnitController::class, 'store']);
Route::put('/unidad/{unidad} ', [UnitController::class, 'update']);
Route::get('/unidad/{unidad} ', [UnitController::class, 'findById']);
Route::put('/unidad/disabled/{unidad} ', [UnitController::class, 'disabled']);
Route::put('/unidad/enabled/{unidad} ', [UnitController::class, 'enabled']);

# Tipo Documento
Route::get('/tipo-documento', [TypeDocumentController::class, 'list']);
Route::post('/tipo-documento', [TypeDocumentController::class, 'store']);
Route::put('/tipo-documento/{id}', [TypeDocumentController::class, 'update']);
Route::get('/tipo-documento/{id}', [TypeDocumentController::class, 'findById']);
Route::put('/tipo-documento/disabled/{id}', [TypeDocumentController::class, 'disabled']);
Route::put('/tipo-documento/enabled/{id}', [TypeDocumentController::class, 'enabled']);
Route::get('/tipo-documento/listar/activos', [TypeDocumentController::class, 'actives']);
Route::get('/tipo-documento/listar/documentClient', [TypeDocumentController::class, 'documentClient']);
Route::get('/tipo-documento/listar/documentCompany', [TypeDocumentController::class, 'documentCompany']);

# Departamento
Route::get('/departamento', [DepartamentController::class, 'list']);
Route::post('/departamento', [DepartamentController::class, 'store']);
Route::put('/departamento/{id} ', [DepartamentController::class, 'update']);
Route::get('/departamento/{id} ', [DepartamentController::class, 'findById']);
Route::get('/departamento/get/all', [DepartamentController::class, 'all']);

# Provincia
Route::get('/provincia', [ProvinceController::class, 'list']);
Route::get('/provincia/departamento/{codigo}', [ProvinceController::class, 'listDepartament']);
Route::post('/provincia', [ProvinceController::class, 'store']);
Route::put('/provincia/{id} ', [ProvinceController::class, 'update']);
Route::get('/provincia/{id} ', [ProvinceController::class, 'findById']);

# Distrito
Route::get('/distrito', [DistrictController::class, 'list']);
Route::post('/distrito', [DistrictController::class, 'store']);
Route::put('/distrito/{id} ', [DistrictController::class, 'update']);
Route::get('/distrito/{id} ', [DistrictController::class, 'findById']);


# Documento Venta
Route::get('/documento-venta', [DocumentSaleController::class, 'list']);
Route::post('/documento-venta', [DocumentSaleController::class, 'store']);
Route::put('/documento-venta/{documentoventa} ', [DocumentSaleController::class, 'update']);
Route::get('/documento-venta/{documentoventa} ', [DocumentSaleController::class, 'findById']);
Route::put('/documento-venta/disabled/{documentoventa} ', [DocumentSaleController::class, 'disabled']);
Route::put('/documento-venta/enabled/{documentoventa} ', [DocumentSaleController::class, 'enabled']);


# Pais
Route::get('/pais', [CountryController::class, 'list']);
Route::post('/pais', [CountryController::class, 'store']);
Route::put('/pais/{pais} ', [CountryController::class, 'update']);
Route::get('/pais/{pais} ', [CountryController::class, 'findById']);
Route::put('/pais/disabled/{pais} ', [CountryController::class, 'disabled']);
Route::put('/pais/enabled/{pais} ', [CountryController::class, 'enabled']);

# Nacionalidad
Route::get('/nacionalidad', [NationalityController::class, 'list']);
Route::post('/nacionalidad', [NationalityController::class, 'store']);
Route::put('/nacionalidad/{nacionalidad} ', [NationalityController::class, 'update']);
Route::get('/nacionalidad/{nacionalidad} ', [NationalityController::class, 'findById']);
Route::put('/nacionalidad/disabled/{nacionalidad} ', [NationalityController::class, 'disabled']);
Route::put('/nacionalidad/enabled/{nacionalidad} ', [NationalityController::class, 'enabled']);
Route::get('/nacionalidad-all', [NationalityController::class, 'listarAll']);


# Requisito
Route::get('/cargo', [ChargeController::class, 'list']);
Route::post('/cargo', [ChargeController::class, 'store']);
Route::put('/cargo/{cargo} ', [ChargeController::class, 'update']);
Route::get('/cargo/{cargo} ', [ChargeController::class, 'findById']);
Route::put('/cargo/disabled/{cargo} ', [ChargeController::class, 'disabled']);
Route::put('/cargo/enabled/{cargo} ', [ChargeController::class, 'enabled']);

# Cargo Publico
Route::get('/cargo-publico', [ChargePublicController::class, 'list']);
Route::post('/cargo-publico', [ChargePublicController::class, 'store']);
Route::put('/cargo-publico/{cargopublico} ', [ChargePublicController::class, 'update']);
Route::get('/cargo-publico/{cargopublico} ', [ChargePublicController::class, 'findById']);
Route::put('/cargo-publico/disabled/{cargopublico} ', [ChargePublicController::class, 'disabled']);
Route::put('/cargo-publico/enabled/{cargopublico} ', [ChargePublicController::class, 'enabled']);

# Modo pago
Route::get('/modo-pago', [PaymentModeController::class, 'list']);
Route::post('/modo-pago', [PaymentModeController::class, 'store']);
Route::put('/modo-pago/{modopago} ', [PaymentModeController::class, 'update']);
Route::get('/modo-pago/{modopago} ', [PaymentModeController::class, 'findById']);
Route::put('/modo-pago/disabled/{modopago} ', [PaymentModeController::class, 'disabled']);
Route::put('/modo-pago/enabled/{modopago} ', [PaymentModeController::class, 'enabled']);

# Estado
Route::get('/estado', [EstateController::class, 'list']);
Route::post('/estado', [EstateController::class, 'store']);
Route::put('/estado/{estado} ', [EstateController::class, 'update']);
Route::get('/estado/{estado} ', [EstateController::class, 'findById']);
Route::put('/estado/disabled/{estado} ', [EstateController::class, 'disabled']);
Route::put('/estado/enabled/{estado} ', [EstateController::class, 'enabled']);
Route::get('/estado/listar/referencia ', [EstateController::class, 'referencia']);
Route::get('/estado/listar/condicion ', [EstateController::class, 'condicion']);
Route::get('/estado/listar/registro-firma ', [EstateController::class, 'registroFirma']);

# Ubigeo
Route::get('/ubigeo', [UbigeoController::class, 'list']);
Route::get('/ubigeo/search-ubigeo', [UbigeoController::class, 'searchUbigeo']);
Route::post('/ubigeo', [UbigeoController::class, 'store']);
Route::put('/ubigeo/{id} ', [UbigeoController::class, 'update']);
Route::get('/ubigeo/{id} ', [UbigeoController::class, 'findById']);


# Condicion
Route::get('/condicion', [ConditionController::class, 'list']);
Route::post('/condicion', [ConditionController::class, 'store']);
Route::put('/condicion/{id}', [ConditionController::class, 'update']);
Route::get('/condicion/{id}', [ConditionController::class, 'findById']);
