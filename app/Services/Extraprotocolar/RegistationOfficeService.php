<?php

namespace App\Services\Extraprotocolar;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\ExtraProtocolar\OficinaRegistral;
use App\Services\Entidad\ClienteService;
use App\Traits\TemplatesExcel\ExtraProtocolar\GenerateDocumentPermisoViajeExcel;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentPermisoViajePDF;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentCertifiedCopy;
use App\Traits\UploadFileStorage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistationOfficeService extends Controller
{

    use GenerateDocumentCertifiedCopy, UploadFileStorage, GenerateDocumentPermisoViajeExcel, GenerateDocumentPermisoViajePDF;

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
        $data = OficinaRegistralorderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }



    public function findById(OficinaRegistral $registrationOffice): OficinaRegistral|array
    {
        return OficinaRegistral::findOrFail($registrationOffice->s_codigo);
    }


    public function disabled(OficinaRegistral $registrationOffice): OficinaRegistral
    {
        return tap($registrationOffice)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(OficinaRegistral $copy): OficinaRegistral
    {
        return tap($copy)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(OficinaRegistral $registrationOffice): OficinaRegistral
    {
        return $this->disabled($registrationOffice);
    }

    public function generateDocument(OficinaRegistral $registrationOffice)
    {
        return $this->createDocumentWord($registrationOffice);
    }

    public function generateExcel(OficinaRegistral $registrationOffice)
    {
        return $this->exportExcel($registrationOffice);
    }

    public function generatePDF(OficinaRegistral $registrationOffice)
    {
        return $this->exportPDF($registrationOffice);
    }

    public function getActiveBySignature(): JsonResource
    {

        $data = OficinaRegistral::orderBy('s_codigo', 'desc')->where('s_codigo', 'OF036')->get();
        return CollectionResource::collection($data);
    }



}
