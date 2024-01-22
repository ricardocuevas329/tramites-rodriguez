<?php

use App\Http\Controllers\Extraprotocolar\{LetterController,
    CertifiedCopyController,
    DiligenceLetterController,
    ScheduledDiligenceController,
    SignatureController,
    BookController,
    ParticipantController,
    PermissionTravelController,
    RegistrationOfficeController};


# Oficina Registral
Route::get('/registration-office', [RegistrationOfficeController::class, 'list']);
Route::post('/registration-office', [RegistrationOfficeController::class, 'store']);
Route::put('/registration-office/{registrationOffice}', [RegistrationOfficeController::class, 'update']);
Route::get('/registration-office/{registrationOffice}', [RegistrationOfficeController::class, 'findById']);
Route::get('/registration-office/generateDocument/{registrationOffice}', [RegistrationOfficeController::class, 'generateDocument']);
Route::get('/registration-office/list/ActiveBySignature', [RegistrationOfficeController::class, 'ActiveBySignature']);


# Copia Certificadas
Route::get('/certified-copy', [CertifiedCopyController::class, 'list']);
Route::post('/certified-copy', [CertifiedCopyController::class, 'store']);
Route::put('/certified-copy/{copy}', [CertifiedCopyController::class, 'update']);
Route::get('/certified-copy/{copy}', [CertifiedCopyController::class, 'findById']);
Route::get('/certified-copy/generateDocument/{copy}', [CertifiedCopyController::class, 'generateDocument']);

# Registro Firmas
Route::get('/signature', [SignatureController::class, 'list']);
Route::post('/signature', [SignatureController::class, 'store']);
Route::put('/signature/{signature}', [SignatureController::class, 'update']);
Route::get('/signature/{signature}', [SignatureController::class, 'findById']);
Route::get('/signature/generateDocument/{signature}', [SignatureController::class, 'generateDocument']);
Route::post('/signature/storeSignatureRepresentation', [SignatureController::class, 'storeSignatureRepresentation']);
Route::get('/signature/SignatureRepresentationById/{id_signature}', [SignatureController::class, 'findSignatureRepresentationById']);
Route::delete('/signature/document/{id_document}', [SignatureController::class, 'delete_document']);
Route::put('/signature/upload-photo/{signature}', [SignatureController::class, 'upload_signature']);
Route::put('/signature/delete-photo/{signature}', [SignatureController::class, 'remove_document_signature']);



# DiligenciaCarta
Route::get('/diligence', [DiligenceLetterController::class, 'list']);
Route::post('/diligence', [ScheduledDiligenceController::class, 'store']);
Route::get('/diligence/view/shipments-scheduled/{id}', [DiligenceLetterController::class, 'findDiligenciaById']);
# Carta

# Carta
Route::get('/letter/motorized', [DiligenceLetterController::class, 'getUserMotorized']);
Route::get('/letter', [LetterController::class, 'list']);
Route::get('/letter/search-district', [LetterController::class, 'search']);
Route::get('/letter-diligence', [LetterController::class, 'newform']);
Route::post('/letter-diligence', [LetterController::class, 'storeDiligence']);
Route::get('/letter-diligence/{letterdiligence} ', [LetterController::class, 'findDiligenciaById']);
Route::get('/letter/{letter}', [LetterController::class, 'findById']);
Route::put('/letter/observation/{letter}', [LetterController::class, 'updateObservation']);
Route::put('/letter/programation/{letter}', [LetterController::class, 'updateProgramation']);
Route::get('/letter/generarOrden/{letter}', [LetterController::class, 'generateOrder']);
Route::get('/letter/generateDocumentExcel/{letter}', [LetterController::class, 'generateDocument']);
Route::get('/letter/generateDocumentExcel/{letter}', [LetterController::class, 'generateExcel']);
Route::get('/letter/generateDocumentPDF/{letter}', [LetterController::class, 'generatePDF']);
Route::post('/letter', [LetterController::class, 'store']);
Route::put('/letter/{letter}', [LetterController::class, 'update']);

# PermisoViaje

Route::get('/permission-travel-external', [PermissionTravelController::class, 'listPermissionTravelExternal']);
Route::get('/permission-travel', [PermissionTravelController::class, 'list']);
Route::post('/permission-travel', [PermissionTravelController::class, 'store']);
Route::put('/permission-travel/{permissiontravel}', [PermissionTravelController::class, 'update']);
Route::get('/permission-travel/{permissiontravel}', [PermissionTravelController::class, 'findById']);
Route::put('/permission-travel/disabled/{permissiontravel}', [PermissionTravelController::class, 'disabled']);
Route::put('/permission-travel/enabled/{permissiontravel}', [PermissionTravelController::class, 'enabled']);
Route::get('/permission-travel/generateDocument/{permissiontravel}', [PermissionTravelController::class, 'generateDocument']);
Route::delete('/permission-travel/document/{id_document}', [PermissionTravelController::class, 'delete_document']);
Route::get('/permission-travel/generateDocumentExcel/{permissiontravel}', [PermissionTravelController::class, 'generateExcel']);
Route::get('/permission-travel/generateDocumentPDF/{permissiontravel}', [PermissionTravelController::class, 'generatePDF']);

# Participante
Route::delete('/participant/{participant}', [ParticipantController::class, 'destroy']);
Route::put('/participant/{participant}', [ParticipantController::class, 'update']);


# Libro
Route::get('/book', [BookController::class, 'list']);
Route::post('/book', [BookController::class, 'store']);
Route::put('/book/{cod_book}', [BookController::class, 'update']);
Route::get('/book/{code}', [BookController::class, 'findById']);
Route::put('/book/disabled/{book}', [BookController::class, 'disabled']);
Route::put('/book/enabled/{book}', [BookController::class, 'enabled']);
Route::get('/book/generateDocument/{book}', [BookController::class, 'generateDocument']);
Route::get('/book/generateDocumentExcel/{book}', [BookController::class, 'generateExcel']);
Route::get('/book/generateDocumentPDF/{book}', [BookController::class, 'generatePDF']);
Route::post('/book/filterBook', [BookController::class, 'filter']);
Route::post('/book/getPrice', [BookController::class, 'getPrice']);
Route::get('/book/findPayment/{code} ', [BookController::class, 'findPayment']);
Route::put('/book/observation/{cod_book} ', [BookController::class, 'updateObservation']);
Route::delete('/book/document/{id_document}', [BookController::class, 'delete_document']);
Route::put('/book/updateDateOpening/{cod_book} ', [BookController::class, 'updateDateOpening']);
