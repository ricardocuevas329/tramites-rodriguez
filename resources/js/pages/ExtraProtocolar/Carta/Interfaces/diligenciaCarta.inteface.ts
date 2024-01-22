import type { IUploadFile } from "@/models/components/upload-file.interface";

export interface IDiligenciaCartaForm{
    s_num_carta: number | null,
    s_recibido_por: string,
    s_recibido_dni: string,
    s_relacion_destinatario: string,
    inmueble: string,
    s_pisos: number | null,
    s_color: string,
    s_puertas: string,
    s_ventanas: string,
    s_proyeccion: string,
    s_observacion: string,
    fotos: IUploadFile[]
}
