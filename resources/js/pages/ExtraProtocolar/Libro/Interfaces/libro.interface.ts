import type {LibroDocument} from "@/models/types";

export type ITypeTab = 'DatosDelUsuario' | 'DetallesDeLosLibrosALegalizar' | 'Observaciones' | 'Documentos'

export interface IlibrosLegalizados {
    id?: number|null,
    libro: string | null,
    denominado: string| null,
    formas: string| null,
    folios: number| null,
    precios: number| null,
    cantidad: number|null,
    numero: number|null,
}

export interface IFormFieldLibro {
    isEdit?: boolean,
    contado: boolean,
    correo: string,
    dni: number|null,
    dni_representa?: number|null,
    libros_legalizados: IlibrosLegalizados[],
    materno?: string,
    nombre: string,
    observacion: string,
    paterno?: string,
    ruc: number|null,
    ruc_facturado: number|null,
    telefono: number|null,
    dni_id_cod:string,
    ruc_id_cod:string,
    dni_representa_id_cod:string,
    ruc_facturado_id_cod:string,
    razon_social?: string,
    persona_natural?: string,
    razon_social2?: string,
    files: LibroDocument[]
}

export interface IUpdateObservationLibro {
    observacion: string,
}

export interface IUpdateDateOpeningLibro {
    fecha: string,
}
