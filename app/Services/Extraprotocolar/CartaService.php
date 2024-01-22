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
use App\Services\Entidad\ClienteService;
use App\Services\Entidad\EmpresaService;
use App\Traits\GenerateCode;
use App\Traits\TemplatesExcel\ExtraProtocolar\GenerateDocumentCartaExcel;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentCartaPDF;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentOrdenPDF;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentCarta;
use App\Traits\UploadFileStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class CartaService extends Controller
{

    use GenerateCode, UploadFileStorage, GenerateDocumentCartaExcel, GenerateDocumentCartaPDF, GenerateDocumentCarta, GenerateDocumentOrdenPDF;

    public function __construct(
        protected ClienteService $clienteService,
        protected DiligenciaCartaDocumentService $diligenciaCartaDocumentService,
        protected DiligenciaProgramadaService $diligenciaProgramadaService,
        protected EmpresaService              $empresaService
    ) {
    }

    public function get(Request $request)
    {

        $filtro = $request->search;
        $data = Carta::with(['remitenteCliente', 'referenteCliente', 'remitenteEmpresa', 'empresaEmpresa', 'facturadoEmpresa', 'facturadoCliente', 'situacion', 'diligenciaCarta.personal'])
            ->orderBy('s_codigo', 'desc')
            ->where(fn(Builder $query) => $query->Filtros($filtro))
            ->paginate(5);

        return CollectionResource::collection($data);
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
                    's_empresa' => $dto->s_referente,
                    's_facturado' => $dto->s_facturado,
                    's_destinatario' => $value['nombre'],
                    's_localidad' => $value['ubicacion'],
                    's_direccioncarta' => $value['direccion'],
                    'de_precio' => $value['precio'],
                    's_observacion' => $dto->s_observacion,
                    'i_tipopago' => $dto->i_tipopago,
                    'i_delivery' => $dto->i_delivery,
                    'i_bajopuerta' => $dto->i_bajopuerta,
                    'i_urgente' => $dto->i_urgente,
                ]);

            }
           // 20543377792

            if (str_starts_with($dto->s_facturado, 'CL')) {
                $client = $this->clienteService->find($dto->s_facturado);
                $client->s_correo =  $dto->facturado_correo;
                $client->s_celular = $dto->facturado_telefono;
                $client->save();
            }else{

                $company = $this->empresaService->find($dto->s_facturado);
                $company->s_email =  $dto->facturado_correo;
                $company->s_telefono =  $dto->facturado_telefono;
                $company->save();

            }

            $client = $this->clienteService->find($dto->s_remitente);
            $client->s_correo =  $dto->formRemitente['remitenteCorreo'];
            $client->s_celular = $dto->formRemitente['remitenteTelefono'];
            $client->save();

            CartaOrden::create([
                's_codigo' => $codigo,
            ]);
        }
        return $codigo;
    }

    public function updateObservation(Carta $letter, $request)
    {
        return $letter->update([
            's_observacion' =>   $request->s_observacion,
        ]);
    }

    public function updateProgramation(Carta $letter, $request)
    {
        return $letter->update([
            's_observacion' =>   $request->s_observacion,
        ]);
    }

    public function storeDiligencia(DiligenciaCartaDto $dto)
    {
        $diligencia_carta = DiligenciaCarta::create($dto->toArray());
        $this->diligenciaProgramadaService->delivered($diligencia_carta->s_num_carta);
        $files = $dto->fotos;
        if ($files && count($files)) {
            foreach ($files as $file => $value) {
                if (isset($value['base64'])) {
                    $folder = 'diligencia-carta-images';
                    $this->diligenciaCartaDocumentService->store(
                        new StoreDiligenciaFotoDto(
                            i_diligencia_carta: $diligencia_carta->i_codigo,
                            s_foto: $this->UploadFilesS3($value['base64'], $folder, $value['type']),
                            s_name: $value['name'],
                            s_type: $value['type'],
                            i_size: $value['size'],
                        )
                    );
                }
            }
        }
        return  $diligencia_carta;
    }

    public function findDiligenciaById($letterdiligence)
    {
      return DiligenciaCarta::with(['fotos', 'personal'])->where('s_num_carta',$letterdiligence)->first();
    }


    public function findById(Carta $letter)
    {

        return Carta::findOrFail($letter->s_carta);
    }


    public function disabled(Carta $letter): Carta
    {
        return tap($letter)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Carta $letter): Carta
    {
        return tap($letter)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Carta $letter): Carta
    {
        return $this->disabled($letter);
    }


    public function GenerateDocumentCarta(Carta $letter)
    {
        return $this->createDocumentWord($letter);
    }

    public function generateExcel(Carta $letter)
    {
        return $this->exportExcel($letter);
    }

    public function generatePDF(Carta $letter)
    {
        return $this->exportPDF($letter);
    }

    public function generateOrden(Carta $letter)
    {

        return $this->exportOrden($letter);
    }

}
