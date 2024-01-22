<?php

namespace App\Services\Extraprotocolar;

use App\Dtos\FirmaRepresentacion\SignatureRepresentationDto;
use App\Http\Controllers\Controller;
use App\Models\ExtraProtocolar\FirmaRepresentacion;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentFirmaRepresentacion;

class SignatureRepresentationService extends Controller
{

    public function __construct(

    )
    {
    }


    public function store(SignatureRepresentationDto $dto): FirmaRepresentacion
    {
        $firma = new FirmaRepresentacion($dto->toArray());
        $firma->save();
        return $firma;
    }

    public function update(FirmaRepresentacion $firma, SignatureRepresentationDto $dto): FirmaRepresentacion
    {
        $firma->update($dto->toArray());
        return $firma;
    }

    public function findById(FirmaRepresentacion $firma): FirmaRepresentacion|array
    {
        return FirmaRepresentacion::findOrFail($firma->s_codigo);
    }


    public function disabled(FirmaRepresentacion $permisoViaje): FirmaRepresentacion
    {
        return tap($permisoViaje)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(FirmaRepresentacion $permisoViaje): FirmaRepresentacion
    {
        return tap($permisoViaje)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(FirmaRepresentacion $permisoViaje): FirmaRepresentacion
    {
        return $this->disabled($permisoViaje);
    }


}
