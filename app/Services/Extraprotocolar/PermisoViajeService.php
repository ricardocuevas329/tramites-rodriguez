<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\Acompanante\AcompananteDto;
use App\Dtos\Cliente\ClienteDto;
use App\Dtos\Participante\ParticipanteDto;
use App\Dtos\PermisoViaje\PermisoViajeDto;
use App\Dtos\PermisoViajeDocument\PermisoViajeDocumentDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\External\Extraprotocolar\PermisoViajeExternal;
use App\Models\ExtraProtocolar\PermisoViaje;
use App\Models\ExtraProtocolar\PermisoViajeDocument;
use App\Services\Entidad\ClienteService;
use App\Traits\TemplatesExcel\ExtraProtocolar\GenerateDocumentPermisoViajeExcel;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentPermisoViajePDF;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentPermisoViaje;
use App\Traits\UploadFileStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function PHPUnit\Framework\isEmpty;

class PermisoViajeService extends Controller
{

    use GenerateDocumentPermisoViaje, UploadFileStorage, GenerateDocumentPermisoViajeExcel, GenerateDocumentPermisoViajePDF;

    public function __construct(
        protected ClienteService              $clienteService,
        protected ParticipanteService         $participanteService,
        protected PermisoViajeDocumentService $permisoViajeDocumentService,
        protected AcompananteService          $acompananteService
    )
    {
    }

    public function get(Request $request): JsonResource
    {

        $filtro = $request->search;
        $data = PermisoViaje::with(['participantes', 'acompanantes'])
            ->orderBy('i_codigo', 'desc')
            ->where(fn(Builder $query) => $query->Filtros($filtro))
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function getExterno(Request $request): JsonResource
    {
        $filtro = $request->search;
        $data = PermisoViajeExternal::with(['participantes', 'usuario_cliente', 'usuario_empresa'])
            ->orderBy('id', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function store(PermisoViajeDto $dto): PermisoViaje
    {

        $permisoViaje = new PermisoViaje($dto->toArray());
        $permisoViaje->save();
        $participants = $dto->participantes;
        $acompanantes = $dto->acompanantes;
        $files = $dto->files;
        if ($files && count($files)) {
            foreach ($files as $file => $value) {
                if (isset($value['base64'])) {
                    $folder = 'permiso-viaje-documents';
                    $this->permisoViajeDocumentService->store(
                        new PermisoViajeDocumentDto(
                            id_permiso_viaje: $permisoViaje->i_codigo,
                            file: $this->UploadFilesS3($value['base64'], $folder, $value['type']),
                            name: $value['name'],
                            type: $value['type'],
                            size: $value['size'],
                        )
                    );
                }
            }
        }
        if (count($participants)) {
            foreach ($participants as $key => $value) {
                $jsonValue = json_encode($value);
                $participant = json_decode($jsonValue);
                $client = $participant->cliente;

                $dataCliente = $this->clienteService->store(
                    new ClienteDto(
                        s_paterno: $client->s_paterno,
                        s_materno: $client->s_materno,
                        s_nombres: $client->s_nombres,
                        s_num_doc: $client->s_num_doc,
                        d_fecha_nac: $client->d_fecha_nac,
                        s_estado_civil: $client->s_estado_civil,
                        s_nacionalidad: $client->s_nacionalidad,
                        s_localidad: $client->s_localidad,
                        s_direccion: $client->s_direccion,
                        s_sexo: $client->s_sexo,
                        //s_correo: $client->s_correo,
                        id_tipo_documento: $client->id_tipo_documento,
                        s_tipoDocu: $client->id_tipo_documento,

                    )
                );
                if ($dataCliente->s_codigo) {

                    $this->participanteService->store(
                        new ParticipanteDto(
                            i_condicion: (int)$participant->i_condicion,
                            i_firma: (int)$participant->i_firma,
                            i_permiso: $permisoViaje->i_codigo,
                            s_edad: $participant->s_edad,
                            s_observacion: '',
                            s_participante: $dataCliente->s_codigo,
                            s_partida: $participant->s_partida,
                            s_sede_reg: $participant->s_sede_reg,
                        )
                    );
                }
            }
        }

        if (count($acompanantes)) {

            foreach ($acompanantes as $key => $value) {

                $jsonValue = json_encode($value);
                $participant = json_decode($jsonValue);
                $client = $participant->cliente;
                if (!isset($participant->i_codigo)) {
                    $this->acompananteService->store(
                        new AcompananteDto(
                            i_condicion: 7,
                            i_permiso: $permisoViaje->i_codigo,
                            s_participante: $client->s_codigo,
                        )
                    );

                }

            }
        }

        return $permisoViaje;
    }

    public function update(PermisoViaje $permisoViaje, PermisoViajeDto $dto): PermisoViaje
    {
        $participants = $dto->participantes;

        $acompanantes = $dto->acompanantes;
        $files = $dto->files;
        $permisoViaje->update($dto->toArray());

        if ($files && count($files)) {
            foreach ($files as $file => $value) {
                if (isset($value['base64'])) {
                    $folder = 'permiso-viaje-documents';
                    $this->permisoViajeDocumentService->store(
                        new PermisoViajeDocumentDto(
                            id_permiso_viaje: $permisoViaje->i_codigo,
                            file: $this->UploadFilesS3($value['base64'], $folder, $value['type']),
                            name: $value['name'],
                            type: $value['type'],
                            size: $value['size'],
                        )
                    );
                }
            }
        }
        if (count($participants)) {

            foreach ($participants as $key => $value) {

                if (!isset($value['i_codigo']) || $value['i_codigo'] == 0) {
                    $jsonValue = json_encode($value);
                    $participant = json_decode($jsonValue);
                    $client = $participant->cliente;

                    $dataCliente = $this->clienteService->store(

                        new ClienteDto(
                            s_paterno: $client->s_paterno,
                            s_materno: $client->s_materno,
                            s_nombres: $client->s_nombres,
                            s_num_doc: $client->s_num_doc,
                            d_fecha_nac: $client->d_fecha_nac,
                            s_estado_civil: $client->s_estado_civil,
                            s_nacionalidad: $client->s_nacionalidad,
                            s_localidad: $client->s_localidad,
                            s_direccion: $client->s_direccion,
                            s_sexo: $client->s_sexo,
                            //s_correo: $client->s_correo,
                            id_tipo_documento: $client->id_tipo_documento
                        )
                    );

                    if ($dataCliente->s_codigo) {

                        $this->participanteService->store(
                            new ParticipanteDto(
                                i_condicion: (int)$participant->i_condicion,
                                i_firma: (int)$participant->i_firma,
                                i_permiso: $permisoViaje->i_codigo,
                                s_edad: $participant->s_edad,
                                s_observacion: '',
                                s_participante: $dataCliente->s_codigo,
                                s_partida: $participant->s_partida,
                                s_sede_reg: $participant->s_sede_reg,
                            )
                        );

                    }
                }

            }
        }

        if (count($acompanantes)) {

            foreach ($acompanantes as $key => $value) {

                $jsonValue = json_encode($value);
                $participant = json_decode($jsonValue);
                $client = $participant->cliente;
                if (!isset($participant->i_codigo)) {
                    $this->acompananteService->store(
                        new AcompananteDto(
                            i_condicion: 7,
                            i_permiso: $permisoViaje->i_codigo,
                            s_participante: $client->s_codigo,
                        )
                    );

                }

            }
        }

        return $permisoViaje;
    }

    public function findById(PermisoViaje $permisoviaje): PermisoViaje|array
    {
        return PermisoViaje::with(['participantes', 'usuario', 'acompanantes', 'files'])
            ->findOrFail($permisoviaje->i_codigo);
    }


    public function disabled(PermisoViaje $permisoViaje): PermisoViaje
    {
        return tap($permisoViaje)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(PermisoViaje $permisoViaje): PermisoViaje
    {
        return tap($permisoViaje)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(PermisoViaje $permisoViaje): PermisoViaje
    {
        return $this->disabled($permisoViaje);
    }

    public function generateDocument(PermisoViaje $permisoViaje)
    {
        return $this->createDocumentWord($permisoViaje);
    }

    public function generateExcel(PermisoViaje $permisoViaje)
    {
        return $this->exportExcel($permisoViaje);
    }

    public function generatePDF(PermisoViaje $permisoViaje)
    {
        return $this->exportPDF($permisoViaje);
    }

    public function countFiles(int $id_permiso_viaje): bool
    {
        $data = PermisoViaje::where('i_codigo', $id_permiso_viaje)->withCount('files')->first();
        if ($data->files_count == 1) {
            return false;
        }
        return true;
    }

    public function deleteDocument(int $id_document): PermisoViajeDocument
    {
        $document = PermisoViajeDocument::find($id_document);
        return $this->permisoViajeDocumentService->destroy($document);
    }
}
