<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\Carta\CartaDto;
use App\Dtos\DiligenciaCarta\DiligenciaCartaDto;
use App\Dtos\DiligenciaFoto\StoreDiligenciaFotoDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Extraprotocolar\Carta;
use App\Models\Extraprotocolar\CartaOrden;
use App\Models\ExtraProtocolar\DiligenciaCarta;
use App\Models\ExtraProtocolar\DiligenciaProgramada;
use App\Models\User;
use App\Services\Entidad\ClienteService;
use App\Traits\GenerateCode;
use App\Traits\TemplatesExcel\ExtraProtocolar\GenerateDocumentCartaExcel;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentCartaPDF;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentOrdenPDF;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentCarta;
use App\Traits\UploadFileStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class DiligenciaCartaService extends Controller
{

    use GenerateCode, UploadFileStorage, GenerateDocumentCartaExcel, GenerateDocumentCartaPDF, GenerateDocumentCarta, GenerateDocumentOrdenPDF;

    public function __construct(
        protected ClienteService $clienteService,
        protected DiligenciaCartaDocumentService $diligenciaCartaDocumentService,
    ) {
    }

    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = DiligenciaProgramada::with(['cartas', 'diligencia_carta', 'motorizado'])
            ->where(fn(Builder $query) => $query->Filtros($filtro))
            ->paginate(10);

        return CollectionResource::collection($data);
    }


    public function findDiligenciaById($diligenciaCarta)
    {
        return DiligenciaCarta::with(['fotos', 'personal'])->where('s_num_carta',$diligenciaCarta)->first();
    }


    public function getUserMotorized(Request $request){

        $filtro = $request->search;
        $usuarios = User::whereHas('asignacionLaboral', function($query1) {
            $query1->where('s_cargo', 'CG005');
        })
        ->where(function ($query) use ($filtro) {
            $query->Filtros($filtro);
        })->with(['tipo_documento'])
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($usuarios);
    }

    public function store(CartaDto $dto)
    {
        $tableCodigo = (new CartaOrden())->getTable();
        $codigo = $this->generateCode($tableCodigo, 's_codigo', 12, 'CN');
        if ($dto->destinatarios && count($dto->destinatarios)) {
            foreach ($dto->destinatarios as $destinatario => $value) {
                $tableCarta = (new Carta())->getTable();
                Carta::create([
                    's_carta' =>  $this->generateCode($tableCarta, 's_carta', 12, 'CA'),
                    's_codigo' =>  $codigo,
                    's_remitente' => $dto->s_remitente,
                    's_empresa' => $dto->s_empresa,
                    's_facturado' => $dto->s_facturado,
                    's_destinatario' => $value['nombre'],
                    's_localidad' => $value['ubicacion'],
                    's_direccioncarta' => $value['direccion'],
                    'de_precio' => $value['precio'],
                    's_observacion' => $dto->s_observacion,
                    'd_fecha_cierre' => $dto->d_fecha_cierre,
                    'i_tipopago' => $dto->i_tipopago,
                    'i_delivery' => $dto->i_delivery,
                    'i_bajopuerta' => $dto->i_bajopuerta,
                    'i_urgente' => $dto->i_urgente,
                ]);
            }
            CartaOrden::create([
                's_codigo' => $codigo,
            ]);
        }
        return $codigo;
    }



    public function findById(Carta $carta)
    {
        return Carta::findOrFail($carta->s_carta);
    }


    public function disabled(Carta $carta): Carta
    {
        return tap($carta)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Carta $carta): Carta
    {
        return tap($carta)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Carta $carta): Carta
    {
        return $this->disabled($carta);
    }


    public function GenerateDocumentCarta(Carta $carta)
    {
        return $this->createDocumentWord($carta);
    }

    public function generateExcel(Carta $carta)
    {
        return $this->exportExcel($carta);
    }

    public function generatePDF(Carta $carta)
    {
        return $this->exportPDF($carta);
    }

    public function generateOrden(Carta $carta)
    {

        return $this->exportOrden($carta);
    }

}
