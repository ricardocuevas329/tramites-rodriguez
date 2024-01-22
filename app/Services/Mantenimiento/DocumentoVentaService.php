<?php

namespace App\Services\Mantenimiento;

use App\Dtos\DocumentoVenta\DocumentoVentaDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\DocumentoVenta;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class DocumentoVentaService
{

    use GenerateCode;

    public function get(Request $request)
    {
        $filtro = $request->search;
        $data = DocumentoVenta::where(function ($query) use ($filtro) {
            $query->filtros($filtro);
        })->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(DocumentoVentaDto $dto): DocumentoVenta
    {
        $tableName = (new DocumentoVenta())->getTable();
        return DocumentoVenta::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'DV'),
            's_abrev' => $dto->s_abrev,
            's_impresora' => $dto->s_impresora,
            's_nombre' => $dto->s_nombre,
            's_serie' => $dto->s_serie,
            'i_tipoComprobanteFe' => (int) $dto->id_tipo_comprobante,
            'i_estado' => 1
        ]);
    }

    public function update(DocumentoVenta $documentoventa, DocumentoVentaDto $dto)
    {
        return $documentoventa->update([
            's_abrev' => $dto->s_abrev,
            's_impresora' => $dto->s_impresora,
            's_nombre' => $dto->s_nombre,
            's_serie' => $dto->s_serie,
            'i_tipoComprobanteFe' => (int) $dto->id_tipo_comprobante,
        ]);
    }

    public function findById(DocumentoVenta $documentoventa): DocumentoVenta
    {
        return $documentoventa;
    }


    public function disabled(DocumentoVenta $documentoventa): DocumentoVenta
    {
        return tap($documentoventa)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(DocumentoVenta $documentoventa): DocumentoVenta
    {
        return tap($documentoventa)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(DocumentoVenta $documentoventa): DocumentoVenta
    {
        return tap($documentoventa)->delete();
    }
}
