<?php

namespace App\Traits\TemplatesWord\ExtraProtocolar;

use App\Models\ExtraProtocolar\Libro;
use App\Traits\ApiResponser;
use App\Traits\DateManipulation;
use App\Traits\StringManipulation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SVG\SVG;

trait GenerateDocumentLibro
{

    use DateManipulation, StringManipulation, ApiResponser;


    protected function createDocumentWord(Libro $book)
    {

        $disk = "formatos";
        $folder = "extraprotocolar/libros";
        $formatFileName = 'CERTIFICACION-LIBRO.docx';
        $now = date('Y-d-m H-i-s');
        $nameFileSave = 'document-' . $now.'_tmp';
        $ciudad = "LIMA, ";

        if (Storage::disk($disk)->exists("$folder/" . $formatFileName)) {

            $replacements =
                [
                    'REGISTRO' => $book->s_libro,
                    'PERTENECE' => $book->empresa->s_nombre,
                    'RUC' => $book->empresa->s_num_doc,
                    'DENOMINACION' => $book->s_denominacion,
                    'FOLIOS' => $book->s_folios,
                    'FORMA' => $book->s_forma,
                    'LUGAR_FECHA' => $ciudad.strtoupper($this->getNameDayMonthYear(Carbon::parse($book->d_fecha_apertura)))
                ];

            $qr_content = "REGISTRO: $book->s_libro | PERTENECE: $book->empresa->s_nombre | RUC: $book->empresa->s_num_doc | DENOMINACION: $book->s_denominacion | FOLIOS: $book->s_folios | FORMA: $book->s_forma";
            $path = Storage::path("$disk/$folder/" . $formatFileName);
            $phpWord = new TemplateProcessor($path);
            $contentSVG = QrCode::format('svg')->size(50)->generate($qr_content);
            $image = SVG::fromString($contentSVG);
            $rasterImage = $image->toRasterImage(600, 600);
            header('Content-Type: image/png');
            $filePNG = $nameFileSave."new_qr_tmp.png";
            imagepng($rasterImage, $filePNG);

            $book->i_imprime = 1;
            $book->save();
            $phpWord->setImageValue("IMAGE_QR", array('path' =>  public_path($filePNG), 'width' => 200, 'height' => 200));
            $phpWord->setValues($replacements);
            $tempFilePath = tempnam(sys_get_temp_dir(), $nameFileSave) . '.docx';
            $phpWord->saveAs($tempFilePath);
            $nameDoc = $nameFileSave .'.docx';
            unlink($filePNG);
            return response()->download($tempFilePath, $nameDoc)->deleteFileAfterSend();


        } else {
            return $this->error("Archivo $formatFileName no Existe!");
        }


    }
}
