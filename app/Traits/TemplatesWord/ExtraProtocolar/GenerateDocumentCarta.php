<?php

namespace App\Traits\TemplatesWord\ExtraProtocolar;

use App\Models\Administracion\Configuracion;
use App\Models\Extraprotocolar\Carta;
use App\Traits\ApiResponser;
use App\Traits\DateManipulation;
use App\Traits\StringManipulation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

trait GenerateDocumentCarta
{

    use DateManipulation, StringManipulation, ApiResponser;


    protected function createDocumentWord(Carta $carta)
    {
        $config = Configuracion::first();
        $now = date('Y-d-m H-i');
        $nameFileSave = 'document-' . $now.'_tmp';
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
        ->setCreator($config->s_empresa)
        ->setTitle("CARTA")
        ->setDescription($config->s_empresa);


       /*
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        $drawing->setName( $config->s_empresa);
        $drawing->setPath( $config->s_ruta_logo);
        $drawing->setHeight(56);
        $spreadsheet->getActiveSheet()->getHeaderFooter()->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);
       */


        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A1:R1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('A9ADA1');


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "NUMERO CARTA");
        $sheet->setCellValue("B1", "FECHA ENTREGA.");
        $sheet->setCellValue("C1", "ACTO NOTARIAL");
        $sheet->setCellValue("D1", "DESCRIPCION");
        $sheet->setCellValue("E1", "CANTIDAD");
        $sheet->setCellValue("R1", "FACTURADO CLIENTE");

        $sheet->fromArray([$carta->s_numcarta], '', 'A2',);
        $sheet->fromArray([$carta->d_fechaEntrega?->format('d/m/Y')], '', "B2",);
        $sheet->fromArray([$carta->s_acto_notarial], '', "C2",);
        $sheet->fromArray([$carta->s_descripcion], '', "D2",);
        $sheet->fromArray([$carta->i_cantidad ], '', "E2",);
        $sheet->fromArray([  str_replace('"', "", $carta->facturadoCliente->pluck('cliente')->pluck('nombre_compuesto')) ], '', "R2",);

        $writer = new Mpdf($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), $nameFileSave) . '.pdf';
        $writer->save($tempFilePath);
        $nameDoc = $nameFileSave.'.pdf';
        return response()->download($tempFilePath,$nameDoc)->deleteFileAfterSend();
    }
}
