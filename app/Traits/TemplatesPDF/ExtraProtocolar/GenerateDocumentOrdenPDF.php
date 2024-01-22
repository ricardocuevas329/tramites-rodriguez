<?php

namespace App\Traits\TemplatesPDF\ExtraProtocolar;

use App\Models\Administracion\Configuracion;
use App\Models\Extraprotocolar\Carta;
use PDF;

trait GenerateDocumentOrdenPDF
{
    public function exportOrden(Carta $carta)
    {

        $config = Configuracion::first();

        $data = ['foo' => 'bar']; // Datos que quieres pasar a la vista

        $pdf = PDF::loadView('reportes.extraprotocolar.orden', $data);

        return $pdf->download('archivo.pdf');

        /*$writer = new Mpdf($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'PermisodeViaje_temp') . '.pdf';
        $writer->save($tempFilePath);
        $now = date('Y-d-m H-i');
        $nameDoc ='PermisodeViaje-'.$now.'.pdf';
        return response()->download($tempFilePath,$nameDoc)->deleteFileAfterSend(true);*/
    }
}
