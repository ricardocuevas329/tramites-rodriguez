<?php

namespace App\Services\Entidad;

use App\Dtos\Empresa\EmpresaDto;
use App\Http\Resources\CollectionResource;
use App\Models\Entidad\Empresa;
use App\Services\ConsultaRucDni\RucService;
use App\Services\Mantenimiento\TipoDocumentoService;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpresaService
{

    use GenerateCode;

    public function __construct(
        protected RucService $rucService,
        protected TipoDocumentoService $tipoDocumentoService

    )
    {
    }

    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = Empresa::where(function ($query) use ($filtro) {
            $query->Filters($filtro);
        })->with(['nacionalidad', 'tipo_documento', 'distrito'])
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(EmpresaDto $dto): Empresa
    {
        return Empresa::create([
            's_anotacion' => $dto->s_anotacion,
            's_celular' => $dto->s_celular,
            's_ciiu' => $dto->s_ciiu,
            's_direccion' => $dto->s_direccion,
            's_email' => $dto->s_email,
            's_localidad' => $dto->s_localidad,
            's_nombre' => $dto->s_nombre,
            's_num_doc' => $dto->s_num_doc,
            's_objeto_social' => $dto->s_objeto_social,
            's_oficina' => $dto->s_oficina,
            's_partida' => $dto->s_partida,
            's_referencia' => $dto->s_referencia,
            's_registro' => $dto->s_registro,
            's_telefono' => $dto->s_telefono,
            's_tip_doc' => $dto->s_tip_doc,
            's_web' => $dto->s_web,
        ]);
    }

    public function update(Empresa $empresa, EmpresaDto $dto)
    {
        return $empresa->update([
            's_anotacion' => $dto->s_anotacion,
            's_celular' => $dto->s_celular,
            's_ciiu' => $dto->s_ciiu,
            's_direccion' => $dto->s_direccion,
            's_email' => $dto->s_email,
            's_localidad' => $dto->s_localidad,
            's_nombre' => $dto->s_nombre,
            's_num_doc' => $dto->s_num_doc,
            's_objeto_social' => $dto->s_objeto_social,
            's_oficina' => $dto->s_oficina,
            's_partida' => $dto->s_partida,
            's_referencia' => $dto->s_referencia,
            's_registro' => $dto->s_registro,
            's_telefono' => $dto->s_telefono,
            's_tip_doc' => $dto->s_tip_doc,
            's_web' => $dto->s_web,
        ]);
    }

    public function findById(Empresa $empresa): Empresa
    {
        return Empresa::with(['nacionalidad', 'tipo_documento'])->findOrFail($empresa->s_codigo);
    }

    public function find(string $s_codigo): Empresa
    {
        return Empresa::findOrFail($s_codigo);
    }

    public function existCompany(string $num_doc, string $tipo_doc): bool
    {
        return is_object(Empresa::where('s_tip_doc', $tipo_doc)
            ->where('s_num_doc', $num_doc)
            ->active()
            ->first());
    }

    public function disabled(Empresa $empresa): Empresa
    {
        return tap($empresa)->update([
            'i_estado' => 0,
            'd_fecha_mod' => date("Y-m-d H:i:s"),
            's_personal_mod' => Auth::user()->s_codigo,
        ]);
    }

    public function enabled(Empresa $empresa): Empresa
    {
        return tap($empresa)->update([
            'i_estado' => 1,
            'd_fecha_mod' => date("Y-m-d H:i:s"),
            's_personal_mod' => Auth::user()->s_codigo,
        ]);
    }

    public function destroy(Empresa $empresa): Empresa
    {
        return $this->disabled($empresa);
    }

    public function findByRuc(int $ruc)
    {
        $num_doc = $ruc;
        $empresa = Empresa::where('s_num_doc', $num_doc)->active()->first();
        if (is_object($empresa)) {
            return $empresa;
        }

        $document =  $this->tipoDocumentoService->findCodRuc();
        if(is_object($document)){
            return $this->rucService->find($num_doc, $document->s_codigo);
        }
    }


    public function findByDocument(Request $request)
    {

        $tipo_doc = $request->tipodocu;
        $num_doc = $request->numdocu;

        $data = Empresa::where(function ($query) use ($tipo_doc, $num_doc) {
            $query->Documento($tipo_doc, $num_doc);
        })->active()->with(['tipo_documento', 'estado', 'oficina_registral'])->first();
        if ($data) {
            return $data;
        } else {
            $documento = $this->tipoDocumentoService->findByCod($tipo_doc);
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

}
