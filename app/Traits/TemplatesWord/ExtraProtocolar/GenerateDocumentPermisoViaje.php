<?php

namespace App\Traits\TemplatesWord\ExtraProtocolar;

use App\Models\Administracion\Configuracion;
use App\Models\ExtraProtocolar\PermisoViaje;
use App\Traits\ApiResponser;
use App\Traits\DateManipulation;
use App\Traits\StringManipulation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

trait GenerateDocumentPermisoViaje
{

    use DateManipulation, StringManipulation, ApiResponser;

    public string $useFileFormatGenerate = '';
    public array $participantsCount = [];

    protected function createDocumentWord(PermisoViaje $permisoViaje)
    {
        $disk = "formatos";
        $folder = "extraprotocolar/permiso-viaje";
        $formatFileName = 'FORMATO-PERMISO-VIAJE-PADRE-HIJO.docx';
        $now = date('Y-d-m H-i');
        $nameFileSave = 'document-' . $now.'_tmp';
        $hijos = collect();
        if (Storage::disk($disk)->exists("$folder/" . $formatFileName)) {

            if (count($permisoViaje?->participantes)) {

                $isExternal = $permisoViaje->i_tipo === 2;
                $participantArray = $permisoViaje->participantes->pluck('participa_como');

                // solo tramite exterior
                // solo tramite interior "PADRE" o "MADRE", "HIJO"
                $searchArray = [["PADRE", "MADRE", "HIJO"]];

                foreach ($searchArray as $formatInfo) {
                    $keywords = $formatInfo;


                    foreach ($keywords as $keyword) {
                        $keywordCount = count(array_keys($participantArray->toArray(), $keyword));
                        $this->participantsCount[$keyword] = $keywordCount;
                    }

                    if ($this->participantsCount["PADRE"] == 1 && $this->participantsCount["MADRE"] == 1 && $this->participantsCount["HIJO"] == 1) {
                        $this->useFileFormatGenerate = "FORMATO-PERMISO-VIAJE-PADRE-MADRE-HIJO.docx";
                        break;
                    }

                    if ($this->participantsCount["PADRE"] == 1 && $this->participantsCount["HIJO"] == 1) {
                        $this->useFileFormatGenerate = "FORMATO-PERMISO-VIAJE-PADRE-HIJO.docx";
                        break;
                    }

                    if ($this->participantsCount["MADRE"] == 1 && $this->participantsCount["HIJO"] == 1) {
                        $this->useFileFormatGenerate = "FORMATO-PERMISO-VIAJE-MADRE-HIJO.docx";
                        break;
                    }

                    if ($this->participantsCount["HIJO"] >= 2) {
                        if ($this->participantsCount["PADRE"] == 1 && $this->participantsCount["MADRE"] == 1) {
                            $this->useFileFormatGenerate = "FORMATO-PERMISO-VIAJE-PADRE-MADRE-MAS-DE-2HIJOS.docx";
                        }
                        if ($this->participantsCount["PADRE"] == 1 && !$this->participantsCount["MADRE"]) {
                            $this->useFileFormatGenerate = "FORMATO-PERMISO-VIAJE-PADRE-MAS-DE-2HIJOS.docx";
                            break;
                        }
                        if ($this->participantsCount["MADRE"] == 1 && !$this->participantsCount["PADRE"]) {
                            $this->useFileFormatGenerate = "FORMATO-PERMISO-VIAJE-MADRE-MAS-DE-2HIJOS.docx";
                            break;
                        }
                    };

                }

                if ($this->useFileFormatGenerate !== '') {


                    $config = Configuracion::first();
                    $DATE = $permisoViaje->d_fecha_reg;
                    $MONTH = strtoupper($this->getNameMonth($DATE));
                    $NUMBER_DAY = $permisoViaje->d_fecha_reg->format('d');
                    $LO = $NUMBER_DAY == 1 ? 'AL ' : 'A LOS ';
                    $PREFIX_DAY = $NUMBER_DAY == 1 ? " DIA" : " DÍAS";
                    $DAY = $LO . strtoupper($this->getDayInString($permisoViaje->d_fecha_reg->format('d'))) . $PREFIX_DAY;
                    $CIUDAD = "LIMA";
                    $YEAR = strtoupper($this->convertToWords($DATE->format("Y")));
                    $TITLE_TRAMITE = $isExternal ? 'EXTERIOR' : 'INTERIOR';
                    $TITLE = "ACTA NOTARIAL AUTORIZACIÓN PARA VIAJE DE MENORES AL $TITLE_TRAMITE DEL PAÍS";
                    $SUBTITLE = "(ART. 94,98 y 99 del d. Ley Nº 1049, Artículo 111º del Código de los Niños y Adolescentes, Ley Nº 27337)";
                    $ABOGADO = "MÓNICA MARGOT TAMBINI ÁVILA";
                    $DESDE = strtoupper($this->getNameDayMonth(Carbon::parse($permisoViaje->d_fecha_sal)));
                    $HASTA = strtoupper($this->getNameDayMonthYear(Carbon::parse($permisoViaje->d_fecha_ret)));

                    $replacements =
                        [
                            'CIUDAD' => $CIUDAD,
                            'MONTH' => $MONTH,
                            'YEAR' => $YEAR,
                            'DAY' => $DAY,
                            'TITLE' => $TITLE,
                            'SUBTITLE' => $SUBTITLE,
                            'ABOGADO' => $ABOGADO,
                            'ADDRESS_NOTARIA' => $config->s_direccion ?? '',
                            'OBSERVACION' => $permisoViaje->s_observacion,
                            'FECHA_DESDE' => $DESDE,
                            'FECHA_HASTA' => $HASTA,
                            'LINEA_TRANSPORTE' => ' ' . $permisoViaje->s_linea,
                            'RUTA' => $permisoViaje->s_ruta,
                            'INICIALES' => $this->getIniciales($permisoViaje?->usuario['nombre_compuesto'])
                        ];


                    $path = Storage::path("$disk/$folder/" . $this->useFileFormatGenerate);
                    $phpWord = new TemplateProcessor($path);


                    foreach ($permisoViaje->participantes as $item) {

                        $participa_como = $item['participa_como'];
                        $cliente = $item['cliente'];
                        $nacionalidad = $cliente['nacionalidad'];
                        $ubigeo = $cliente['ubigeo'];

                        $direccion = $cliente['s_direccion'];
                        $tipo_documento = $cliente['tipo_documento'];
                        $tipo_documento_abrev = $tipo_documento ? $tipo_documento['s_abrev'] : '';
                        $tipo_documento_num_doc = $cliente['s_num_doc'] ?? '';
                        $edad = $item->s_edad;

                        $nom_compuesto = $cliente['nombre_compuesto'] ? strtoupper($cliente['nombre_compuesto']) : '';
                        $gentilicio = $nacionalidad ? strtoupper($nacionalidad['s_gentilicio']) : '';
                        $distrito = $ubigeo ? strtoupper($ubigeo['distrito']) : '';
                        $sr = $participa_como == "MADRE" ? 'DOÑA' : 'DON';

                        if ($this->participantsCount["HIJO"] >= 2 && $participa_como == "HIJO") {
                            $hijos->push(['PERSONA_HIJO' => $nom_compuesto, 'TIPO_DOC_HIJO' => $tipo_documento_abrev, 'NUM_DOC_HIJO' => $tipo_documento_num_doc, 'EDAD_HIJO' => $edad]);
                        } else {
                            $phpWord->setValues([
                                'PERSONA_' . $participa_como => $nom_compuesto,
                                'TIPO_DOC_' . $participa_como => $tipo_documento_abrev,
                                'NUM_DOC_' . $participa_como => $tipo_documento_num_doc,
                                'ADDRESS_' . $participa_como => $direccion,
                                'NACIONALIDAD_' . $participa_como => $gentilicio,
                                'DISTRITO_' . $participa_como => $distrito,
                                'SR_' . $participa_como => $sr,
                                'EDAD_' . $participa_como => $edad,
                            ]);
                        }

                    }

                    if ($this->participantsCount["HIJO"] >= 2) {

                        $phpWord->cloneBlock('HIJO_BLOCK', count($hijos->toArray()));

                        foreach ($hijos->toArray() as $hijo) {
                            foreach ($hijo as $search => $replace) {
                                $phpWord->setValue($search, $replace, 1);
                            }
                        }

                    }

                    $phpWord->setValues($replacements);
                    $tempFilePath = tempnam(sys_get_temp_dir(), $nameFileSave) . '.docx';
                    $phpWord->saveAs($tempFilePath);
                    $nameDoc = $nameFileSave .'.docx';
                    return response()->download($tempFilePath, $nameDoc)->deleteFileAfterSend();

                } else {
                    return $this->error("No se puede generar el Documento con estos participantes!");
                }

            } else {
                return $this->error("Para Generar el Documento agregar Participantes!");
            }
        } else {
            return $this->error("Archivo $formatFileName no Existe!");
        }
    }
}
