<?php

namespace App\Services\Extraprotocolar;

use App\Dtos\CopiaCertificada\CopiaCertificadaDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Extraprotocolar\CopiaCertificada;
use App\Services\Entidad\ClienteService;
use App\Traits\TemplatesExcel\ExtraProtocolar\GenerateDocumentPermisoViajeExcel;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentPermisoViajePDF;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentCertifiedCopy;
use App\Traits\UploadFileStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertifiedCopyService extends Controller
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
        $data = CopiaCertificada::with(['empresa', 'personal', 'legalizado'])
            ->orderBy('s_codigo', 'desc')
            ->where(fn(Builder $query) => $query->Filtros($filtro))
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(CopiaCertificadaDto $dto): CopiaCertificada
    {

        $copy = new CopiaCertificada($dto->toArray());
        $copy->save();
        return $copy;
    }

    public function update(CopiaCertificada $copy, CopiaCertificadaDto $dto): CopiaCertificada
    {
        $copy->update($dto->toArray());
        return $copy;
    }

    public function findById(CopiaCertificada $copy): CopiaCertificada|array
    {
        return CopiaCertificada::with(['empresa', 'personal', 'legalizado'])
            ->findOrFail($copy->s_codigo);
    }


    public function disabled(CopiaCertificada $copy): CopiaCertificada
    {
        return tap($copy)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(CopiaCertificada $copy): CopiaCertificada
    {
        return tap($copy)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(CopiaCertificada $copy): CopiaCertificada
    {
        return $this->disabled($copy);
    }

    public function generateDocument(CopiaCertificada $copy)
    {
        return $this->createDocumentWord($copy);
    }

    public function generateExcel(CopiaCertificada $copy)
    {
        return $this->exportExcel($copy);
    }

    public function generatePDF(CopiaCertificada $copy)
    {
        return $this->exportPDF($copy);
    }

}
