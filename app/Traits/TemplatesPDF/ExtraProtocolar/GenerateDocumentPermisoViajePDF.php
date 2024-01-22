<?php

namespace App\Traits\TemplatesPDF\ExtraProtocolar;

use App\Models\Administracion\Configuracion;
use App\Models\ExtraProtocolar\PermisoViaje;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

trait GenerateDocumentPermisoViajePDF
{
    public function exportPDF(PermisoViaje $permisoViaje)
    {

        $config = Configuracion::first();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
        ->setCreator($config->s_empresa)
        ->setTitle("PERMISO DE VIAJE ".$permisoViaje->tipo_viaje)
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
        $sheet->setCellValue("A1", "CODIGO");
        $sheet->setCellValue("B1", "FECHA INSC.");
        $sheet->setCellValue("D1", "TIPO VIAJE");
        $sheet->setCellValue("E1", "FECHA SALIDA");
        $sheet->setCellValue("G1", "TRANSPORTE");
        $sheet->setCellValue("H1", "LINEA");
        $sheet->setCellValue("I1", "RUTA");
        $sheet->setCellValue("J1", "RETORNO");
        $sheet->setCellValue("K1", "OBSERVACION");
        $sheet->setCellValue("N1", "VIAJA");
        $sheet->setCellValue("O1", "FORMATO");
        $sheet->setCellValue("P1", "d_fecha_reg");
        $sheet->setCellValue("Q1", "PERSONAL REGISTRO");
        $sheet->setCellValue("R1", "PARTICIPANTES");



        $sheet->fromArray([$permisoViaje->i_codigo], '', 'A2',);
        $sheet->fromArray([$permisoViaje->d_fecha_ins?->format('d/m/Y')], '', "B2",);
        $sheet->fromArray([$permisoViaje->tipo_viaje], '', "D2",);
        $sheet->fromArray([$permisoViaje->d_fecha_sal?->format('d/m/Y')], '', "E2",);
        $sheet->fromArray([$permisoViaje->d_fecha_ret?->format('d/m/Y')], '', "F2",);
        $sheet->fromArray([$permisoViaje->tipo_transporte], '', "G2",);
        $sheet->fromArray([$permisoViaje->s_linea], '', "H2",);
        $sheet->fromArray([$permisoViaje->s_ruta], '', "I2",);
        $sheet->fromArray([$permisoViaje->s_observacion], '', "K2",);
        $sheet->fromArray([$permisoViaje->solo_acompanado], '', "N2",);
        $sheet->fromArray([$permisoViaje->formato], '', "O2",);
        $sheet->fromArray([$permisoViaje->d_fecha_reg?->format('d/m/Y')], '', "P2",);
        $sheet->fromArray([$permisoViaje?->usuario->nombre_compuesto], '', "Q2",);
        $sheet->fromArray([str_replace('"', "", $permisoViaje->participantes->pluck('cliente')->pluck('nombre_compuesto')) ], '', "R2",);

        $writer = new Mpdf($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'PermisodeViaje_temp') . '.pdf';
        $writer->save($tempFilePath);
        $now = date('Y-d-m H-i');
        $nameDoc ='PermisodeViaje-'.$now.'.pdf';
        return response()->download($tempFilePath,$nameDoc)->deleteFileAfterSend(true);
    }
}
