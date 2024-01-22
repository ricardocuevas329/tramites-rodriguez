<?php

namespace App\Services\External\Auth;

use App\Dtos\External\Auth\AuthRegisterDto;
use App\Models\External\Auth\UserClientExternal;
use App\Models\External\Auth\UserCompanyExternal;
use App\Services\Mantenimiento\TipoDocumentoService;

class AuthService
{

    protected array $searchJuridica = ['RUC', 'R.U.C', 'ruc', 'r.u.c'];

    public function __construct(
        protected TipoDocumentoService $service,
    )
    {

    }



    public function register(AuthRegisterDto $dto)
    {


        if ($this->service->findExistDocument($dto->id_tipo_documento, $this->searchJuridica)) {
            return UserCompanyExternal::create($dto->toArray());
        }

        return UserClientExternal::create(
            $dto->toArray()
        );
    }

    public function findExistEmail(string $email, string $id_tipo_documento, string $documento): bool
    {
        if ($this->service->findExistDocument($id_tipo_documento, $this->searchJuridica)) {
            if (UserCompanyExternal::where('s_email', $email)
                ->where('s_tip_doc', $id_tipo_documento)
                ->where('s_num_doc', $documento)
                ->where('i_estado', 1)
                ->first()) {
                return true;
            }
        }

        if (UserClientExternal::where('s_correo', $email)
            ->where('s_tipoDocu', $id_tipo_documento)
            ->where('s_num_doc', $documento)
            ->where('i_estado', 1)
            ->first()) {
            return true;
        }

        return false;
    }

    public function checkDisabled(string $email): bool
    {

        if (UserCompanyExternal::where('s_email', $email)
            ->where('i_estado', 0)
            ->first()) {
            return true;
        }


        if (UserClientExternal::where('s_correo', $email)
            ->where('i_estado', 0)
            ->first()) {
            return true;
        }

        return false;
    }

}
