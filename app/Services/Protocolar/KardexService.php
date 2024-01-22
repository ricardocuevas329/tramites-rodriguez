<?php

namespace App\Services\Protocolar;

use App\Dtos\Kardex\StoreKardexDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\ExtraProtocolar\PermisoViajeDocument;
use App\Models\Protocolar\Kardex;
use App\Services\Entidad\ClienteService;
use App\Services\ExtraProtocolar\ParticipanteService;
use App\Services\ExtraProtocolar\PermisoViajeDocumentService;
use App\Traits\TemplatesExcel\ExtraProtocolar\GenerateDocumentPermisoViajeExcel;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentPermisoViajePDF;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentPermisoViaje;
use App\Traits\UploadFileStorage;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KardexService 
{

    use GenerateDocumentPermisoViaje, UploadFileStorage, GenerateDocumentPermisoViajeExcel, GenerateDocumentPermisoViajePDF;

    public function __construct(
        protected ClienteService              $clienteService,
        protected ParticipanteService         $participanteService,
        protected PermisoViajeDocumentService $permisoViajeDocumentService,
    )
    {
    }

    public function get(Request $request): JsonResource
    {
        $filtro = $request->search;
        $from = $request->from;
        $to = $request->to;
        $data = Kardex::orderBy('s_codigo', 'desc')
            ->with(['cliente','empresa','asesor','estado'])
             ->where(fn(Builder $query) => $query->Filtros($filtro))
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function store(StoreKardexDto $dto): Kardex
    {
        $kardex = new Kardex($dto->toArray());
        $kardex->save();
        return $kardex;
    }

    public function update(Kardex $kardex, StoreKardexDto $dto): Kardex
    {
        $kardex->update($dto->toArray());
        return $kardex;
    }

    public function findById(Kardex $kardex): Kardex|array
    {
        return Kardex::findOrFail($kardex->s_codigo);
    }

    public function exists(string $type_kardex, string $kardex): bool
    {
        $kardex_format = str_pad($kardex, 10, "0", STR_PAD_LEFT);
        return Kardex::where('s_tipokardex', $type_kardex)->where('s_kardex', $kardex_format)->exists();
    }

    public function disabled(Kardex $kardex): Kardex
    {
        return tap($kardex)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Kardex $kardex): Kardex
    {
        return tap($kardex)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Kardex $kardex): Kardex
    {
        return $this->disabled($kardex);
    }

    public function generateDocument(Kardex $kardex)
    {
        return $this->createDocumentWord($kardex);
    }

    public function generateExcel(Kardex $kardex)
    {
        return $this->exportExcel($kardex);
    }

    public function generatePDF(Kardex $kardex)
    {
        return $this->exportPDF($kardex);
    }

    public function countFiles(int $id_permiso_viaje): bool
    {
        $data = Kardex::where('i_codigo', $id_permiso_viaje)->withCount('files')->first();
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
