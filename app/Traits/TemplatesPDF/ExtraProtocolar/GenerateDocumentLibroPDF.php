<?php

namespace App\Traits\TemplatesPDF\ExtraProtocolar;

use App\Models\ExtraProtocolar\Libro;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;


trait GenerateDocumentLibroPDF
{

    use ApiResponser;

    public function exportPDF(Libro $libro)
    {
        $disk = "formatos";
        $folder = "extraprotocolar/libros";
        $formatFileName = 'LIBRO-FORMATO.pdf';
        if (Storage::disk($disk)->exists("$folder/" . $formatFileName)) {
            $archivo = storage_path("app/$disk/$folder/$formatFileName");
            return response()->download($archivo, "formato");
        } else {
            return $this->error("Archivo $formatFileName no Existe!");
        }

    }
}
