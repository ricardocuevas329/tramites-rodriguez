<?php

namespace App\Traits\TemplatesExcel\ExtraProtocolar;

use App\Models\Extraprotocolar\Carta;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

trait GenerateDocumentCartaExcel
{
    public function exportExcel(Carta $carta)
    {

        $spreadsheet = new Spreadsheet();
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A4:N4')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('A9ADA1');


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "REGISTRO DE CARTAS");

        $sheet->setCellValue("A4", "CARTAS");
        $sheet->setCellValue("B4", "COD ORDEN.");
        $sheet->setCellValue("C4", "Nº CARTA");
        $sheet->setCellValue("D4", "FECHA DE INGRESO");
        $sheet->setCellValue("E4", "REMITENTE");
        $sheet->setCellValue("F4", "REFERENTE");
        $sheet->setCellValue("G4", "DESTINATARIO");
        $sheet->setCellValue("H4", "DISTRITO");
        $sheet->setCellValue("I4", "DIRECCIÓN");
        $sheet->setCellValue("J4", "FECHA DILIGENCIA");
        $sheet->setCellValue("K4", "PRECIO");
        $sheet->setCellValue("L4", "DELIVERY");
        $sheet->setCellValue("M4", "BAJO PUERTA");
        $sheet->setCellValue("N4", "SITUACIÓN");

        $sheet->fromArray([$carta->s_carta], '', 'A5',);
        $sheet->fromArray([$carta->s_codigo], '', 'B5',);
        $sheet->fromArray([$carta->s_numcarta], '', 'C5',);
        $sheet->fromArray([$carta->d_fecha?->format('d/m/Y')], '', "D5",);
        $sheet->fromArray([$carta?->remitenteCliente[0]->nombre_compuesto], '', "E5",);
        $sheet->fromArray([$carta?->referenteCliente[0]->nombre_compuesto], '', "F5",);
        $sheet->fromArray([$carta->s_destinatario], '', 'G5',);
        $sheet->fromArray([$carta->s_localidad], '', 'H5',);
        $sheet->fromArray([$carta->s_direccioncarta], '', 'I5',);
        $sheet->fromArray([$carta->d_fechaEntrega?->format('d/m/Y')], '', "J5",);
        $sheet->fromArray([$carta->de_precio], '', 'K5',);
        $sheet->fromArray([$carta->i_delivery==1 ? "SI":"NO"], '', 'L5',);
        $sheet->fromArray([$carta->i_bajopuerta==1 ? "SI":"NO"], '', 'M5',);
        $sheet->fromArray([$carta?->situacion[0]->s_nombre], '', 'N5',);


        $writer = new Xlsx($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'carta_temp') . '.docx';
        $writer->save($tempFilePath);
        $now = date('Y-d-m H-i');
        $nameDoc ='Carta-'.$now.'.docx';
        return response()->download($tempFilePath,$nameDoc)->deleteFileAfterSend(true);

    }
}
