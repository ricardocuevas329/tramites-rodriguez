<?php

namespace App\Traits\TemplatesWord\ExtraProtocolar;

use App\Models\ExtraProtocolar\Firma;
use App\Traits\ApiResponser;
use App\Traits\DateManipulation;
use App\Traits\StringManipulation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SVG\SVG;

trait GenerateDocumentFirma
{

    use DateManipulation, StringManipulation, ApiResponser;

    public string $useFileFormatGenerate = 'CERTIFICACION-FIRMA.docx';


    protected function createDocumentWord(Firma $copy)
    {

        $disk = "formatos";
        $folder = "extraprotocolar/firma";
        $now = date('Y-d-m H-i-s');
        $nameFileSave = 'document-' . $now . '_tmp';
        if (Storage::disk($disk)->exists("$folder/" . $this->useFileFormatGenerate)) {



            $DATE_REG = Carbon::parse($copy->d_fechaRegistro);
            $MONTH_REG = strtoupper($this->getNameMonth($DATE_REG));


            $CIUDAD = "LIMA";
            $FECHA_REG = $copy->d_fechaRegistro->format('d').' de '.$MONTH_REG.' de '.$copy->d_fechaRegistro->format('Y');
            $CLIENTE = $copy->cliente?->nombre_compuesto ?? '';
            $TIPO_DOCUMENTO = $copy->cliente?->tipo_documento?->s_nombre ?? '';
            $NUMERO_DOC = $copy->cliente?->s_num_doc ?? '';

            $replacements =
                [
                    'CIUDAD' => $CIUDAD,
                    'NOMBRE_CLIENTE' => $CLIENTE,
                    'TIPO_DOCUMENTO' => $TIPO_DOCUMENTO,
                    'NUMERO_DOC' => $NUMERO_DOC,
                    'FECHA' => $FECHA_REG,
                    'NUMERO_REG'=> $copy->s_numeroReg ?? ''
                ];

            $qr_content = "CODIGO: $copy->s_codigo | CLIENTE: $CLIENTE | TIPO_DOCUMENTO: $TIPO_DOCUMENTO | DOCUMENTO: $NUMERO_DOC";

            $path = Storage::path("$disk/$folder/" . $this->useFileFormatGenerate);
            $phpWord = new TemplateProcessor($path);
            $contentSVG = QrCode::format('svg')->size(50)->generate($qr_content);
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
