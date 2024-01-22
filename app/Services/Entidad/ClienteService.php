<?php

namespace App\Services\Entidad;

use App\Dtos\Cliente\ClienteDto;
use App\Http\Resources\CollectionResource;
use App\Models\Entidad\Cliente;
use App\Models\Entidad\Empresa;
use App\Services\ConsultaRucDni\CarnetExtranjeriaService;
use App\Services\ConsultaRucDni\DniService;
use App\Services\ConsultaRucDni\RucService;
use App\Services\Mantenimiento\TipoDocumentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteService
{


    public function __construct(
        protected TipoDocumentoService     $tipoDocumentoService,
        protected DniService               $dniService,
        protected RucService               $rucService,
        protected CarnetExtranjeriaService $carnetExtranjeriaService,

    )
    {
    }

    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = Cliente::where(function ($query) use ($filtro) {
            return $query->Filters($filtro);
        })
            ->with(['tipo_documento', 'ubigeo', 'nacionalidad'])
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function search(Request $request)
    {

        $filtro = $request->search;
        $data = Cliente::where(function ($query) use ($filtro) {
            return $query->Filters($filtro);
        })
            ->orderBy('s_codigo', 'desc')
            ->limit(5)
            ->get();

        return CollectionResource::collection($data);

    }

    public function store(ClienteDto $dto): Cliente
    {
        return Cliente::create($dto->toArray());
    }

    public function update(Cliente $cliente, ClienteDto $dto)
    {
        return $cliente->update($dto->toArray());
    }

    public function findById(Cliente $cliente): Cliente
    {
        return Cliente::with(['ubigeo', 'tipo_documento', 'nacionalidad'])->findOrFail($cliente->s_codigo);
    }

    public function find(string $s_codigo): Cliente
    {
        return Cliente::findOrFail($s_codigo);
    }

    public function existClient(string $num_doc, string $tipo_doc): bool
    {
        return is_object(Cliente::where('s_tipoDocu', $tipo_doc)
            ->where('s_num_doc', $num_doc)
            ->active()
            ->first());
    }

    public function findByDocument(Request $request)
    {

        $tipo_doc = $request->tipodocu;
        $num_doc = $request->numdocu;

        $client = Cliente::where(function ($query) use ($tipo_doc, $num_doc) {
            $query->Documento($tipo_doc, $num_doc);
        })->active()->with(['tipo_documento', 'ubigeo', 'nacionalidad'])->first();
        if ($client) {
            return $client;
        } else {

            $documento = $this->tipoDocumentoService->findByCod($tipo_doc);
            if ($this->tipoDocumentoService->searchExistNameByCod($documento->s_abrev, 'D.N.I')) {
                return $this->dniService->find($num_doc, $tipo_doc);
            }

            if ($this->tipoDocumentoService->searchExistNameByCod($documento->s_abrev, 'RUC')) {
                $bussiness = Empresa::where(function ($query) use ($tipo_doc, $num_doc) {
                    $query->Documento($tipo_doc, $num_doc);
                })->first();
                if (is_object($bussiness)) {
                    return $bussiness;
                }
                return $this->rucService->find($num_doc, $tipo_doc);
            }

            if ($this->tipoDocumentoService->searchExistNameByCod($documento->s_abrev, 'C.E')) {
                return $this->carnetExtranjeriaService->find($num_doc, $tipo_doc);
            }
        }
    }


    public function disabled(Cliente $cliente): Cliente
    {
        return tap($cliente)->update([
            'i_estado' => 0,
            'd_fecha_mod' => date("Y-m-d H:i:s"),
            's_personal_mod' => Auth::user()->s_codigo,
        ]);
    }

    public function enabled(Cliente $cliente): Cliente
    {
        return tap($cliente)->update([
            'i_estado' => 1,
            'd_fecha_mod' => date("Y-m-d H:i:s"),
            's_personal_mod' => Auth::user()->s_codigo,
        ]);
    }

    public function destroy(Cliente $cliente): Cliente
    {
        return $this->disabled($cliente);
    }

    public function findByDni(int $dni)
    {

        $tipo_doc = "TD001";
        $num_doc = $dni;

        $client = Cliente::where(function ($query) use ($tipo_doc, $num_doc) {
            $query->Documento($tipo_doc, $num_doc);
        })->active()->first();
        if ($client) {
            return $client;
        } else {

            $documento = $this->tipoDocumentoService->findByCod($tipo_doc);
            if ($this->tipoDocumentoService->searchExistNameByCod($documento->s_abrev, 'D.N.I')) {
                return $this->dniService->find($num_doc, $tipo_doc);
            }

            if ($this->tipoDocumentoService->searchExistNameByCod($documento->s_abrev, 'RUC')) {
                return $this->rucService->find($num_doc, $tipo_doc);
            }

            if ($this->tipoDocumentoService->searchExistNameByCod($documento->s_abrev, 'C.E')) {
                return $this->carnetExtranjeriaService->find($num_doc, $tipo_doc);
            }
        }
    }


}
