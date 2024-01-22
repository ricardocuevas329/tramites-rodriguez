<?php

namespace App\Traits\TemplatesWord\ExtraProtocolar;

use App\Models\Extraprotocolar\CopiaCertificada;
use App\Traits\ApiResponser;
use App\Traits\DateManipulation;
use App\Traits\StringManipulation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SVG\SVG;

trait GenerateDocumentCertifiedCopy
{

    use DateManipulation, StringManipulation, ApiResponser;

    public string $useFileFormatGenerate = 'COPIA-CERTIFICADA.docx';


    protected function createDocumentWord(CopiaCertificada $copy)
    {
        $disk = "formatos";
        $folder = "extraprotocolar/copia-certificada";
        $now = date('Y-d-m H-i');
        $nameFileSave = 'document-' . $now . '_tmp';
        if (Storage::disk($disk)->exists("$folder/" . $this->useFileFormatGenerate)) {


            $DATE_LEGALIZADO = Carbon::parse($copy->d_fechaLegalizado);
            $DATE_REG = Carbon::parse($copy->d_fecha);
            $MONTH_REG = strtoupper($this->getNameMonth($DATE_REG));
            $MONTH_LEGALIZADO = strtoupper($this->getNameMonth($DATE_LEGALIZADO));

            $CIUDAD = "LIMA";
            $FECHA_LIRBO = $copy->d_fechaLegalizado->format('d').' de '.$MONTH_LEGALIZADO.' de '.$copy->d_fechaLegalizado->format('Y');
            $FECHA_REG = $copy->d_fecha->format('d').' de '.$MONTH_REG.' de '.$copy->d_fecha->format('Y');
            $ABOGADO = $copy->legalizado?->nombre_compuesto ?? '';
            $EMPRESA = $copy->empresa?->nombre_compuesto ?? '';

            $replacements =
                [
                    'CIUDAD' => $CIUDAD,
                    'NUMERO_COPIA' => (int)$copy->i_copias,
                    'NUMERO_FOLIO' => $copy->s_descripcion ?? '',
                    'LIBRO' => $copy->s_libros ?? '',
                    'CONSTA' => (int)$copy->s_consta,
                    'TIPO_FOLIO' => $copy->s_folios ?? '',
                    'EMPRESA' => $EMPRESA,
                    'ABOGADO' => $ABOGADO,
                    'FECHA_LIBRO' => $FECHA_LIRBO,
                    'FECHA' => $FECHA_REG,
                    'NUMERO_REG'=> $copy->s_numeroReg ?? ''
                ];

            $qr_content = "CODIGO: $copy->s_codigo | LIBRO: $copy->s_libros | ABOGADO: $ABOGADO | EMPRESA: $EMPRESA";

            $path = Storage::path("$disk/$folder/" . $this->useFileFormatGenerate);
            $phpWord = new TemplateProcessor($path);
            $contentSVG = QrCode::format('svg')->size(50)->generate( $qr_content);
            $image = SVG::fromString($contentSVG);
            $rasterImage = $image->toRasterImage(600, 600);
            header('Content-Type: image/png');
            $filePNG = $nameFileSave."new_qr_tmp.png";
            imagepng($rasterImage, $filePNG);
            $phpWord->setImageValue("IMAGE_QR", array('path' =>  public_path($filePNG), 'width' => 200, 'height' => 200));
            $phpWord->setValues($replacements);
            $tempFilePath = tempnam(sys_get_temp_dir(), $nameFileSave) . '.docx';
            $phpWord->saveAs($tempFilePath);
            $nameDoc = $nameFileSave . '.docx';
            unlink($filePNG);
            return response()->download($tempFilePath, $nameDoc)->deleteFileAfterSend();


        } else {
            return $this->error("Archivo $this->useFileFormatGenerate no Existe!");
        }
    }
}
