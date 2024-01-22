<?php

namespace App\Traits\TemplatesExcel\ExtraProtocolar;

use App\Models\ExtraProtocolar\PermisoViaje;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

trait GenerateDocumentPermisoViajeExcel
{
    public function exportExcel(PermisoViaje $permisoViaje)
    {


        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue("C1", "NUMERO");
        $sheet->setCellValue("D1", "TIPO VIAJE");
        $sheet->setCellValue("E1", "FECHA SALIDA");
        $sheet->setCellValue("F1", "FECHA RETORNO");
        $sheet->setCellValue("G1", "TRANSPORTE");
        $sheet->setCellValue("H1", "LINEA");
        $sheet->setCellValue("I1", "RUTA");
        $sheet->setCellValue("J1", "RETORNO");
        $sheet->setCellValue("K1", "OBSERVACION");
        $sheet->setCellValue("L1", "HIJO");
        $sheet->setCellValue("M1", "EDAD");
        $sheet->setCellValue("N1", "VIAJA");
        $sheet->setCellValue("O1", "FORMATO");
        $sheet->setCellValue("P1", "d_fecha_reg");
        $sheet->setCellValue("Q1", "PERSONAL REGISTRO");
        $sheet->setCellValue("R1", "PARTICIPANTES");

        $sheet->fromArray([$permisoViaje->i_codigo], '', 'A2',);
        $sheet->fromArray([$permisoViaje->d_fecha_ins?->format('d/m/Y')], '', "B2",);
        $sheet->fromArray([$permisoViaje->i_numero], '', "C2",);
        $sheet->fromArray([$permisoViaje->tipo_viaje], '', "D2",);
        $sheet->fromArray([$permisoViaje->d_fecha_sal?->format('d/m/Y')], '', "E2",);
        $sheet->fromArray([$permisoViaje->d_fecha_ret?->format('d/m/Y')], '', "F2",);
        $sheet->fromArray([$permisoViaje->tipo_transporte], '', "G2",);
        $sheet->fromArray([$permisoViaje->s_linea], '', "H2",);
        $sheet->fromArray([$permisoViaje->s_ruta], '', "I2",);
        $sheet->fromArray([$permisoViaje->retorno], '', "J2",);
        $sheet->fromArray([$permisoViaje->s_observacion], '', "K2",);
        $sheet->fromArray([$permisoViaje->s_hijo], '', "L2",);
        $sheet->fromArray([$permisoViaje->s_edad], '', "M2",);
        $sheet->fromArray([$permisoViaje->solo_acompanado], '', "N2",);
        $sheet->fromArray([$permisoViaje->formato], '', "O2",);
        $sheet->fromArray([$permisoViaje->d_fecha_reg?->format('d/m/Y')], '', "P2",);
        $sheet->fromArray([$permisoViaje?->usuario->nombre_compuesto], '', "Q2",);
        $sheet->fromArray([  str_replace('"', "", $permisoViaje->participantes->pluck('cliente')->pluck('nombre_compuesto')) ], '', "R2",);


        $writer = new Xlsx($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'permiso_travel_temp') . '.docx';
        $writer->save($tempFilePath);
        $now = date('Y-d-m H-i');
        $nameDoc ='PermisodeViaje-'.$now.'.docx';
        return response()->download($tempFilePath,$nameDoc)->deleteFileAfterSend(true);

    }
}
