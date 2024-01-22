import type { Cliente, Empresa } from "@/models/types";
import { type IDestinatario } from "@/pages/ExtraProtocolar/Carta/Interfaces/destinatario.interface";


interface ITabFacturadoForm {
    num_documento: string,
    nombre: string,
    distrito: string,
    direccion: string
}
interface ITabDestinatarioForm {
    nombre: string,
    distrito: string,
    precio: string
}

interface ITabObservacionForm {
    observacion: string,
    delivery: boolean,
    bajo_puerta: boolean,
    urgente: boolean,
    al_contado: boolean,
    fecha_termino: string
}



export interface ICartaFormStore {
    s_remitente: string | null;
    s_referente: string;
    s_facturado: string;
    s_observacion: string;
    i_tipopago: boolean;
    i_delivery: boolean;
    i_bajopuerta: boolean;
    i_urgente: boolean;
    destinatarios?: IDestinatario[];
    remitente: Cliente|null;
    referente: Cliente|null;
    facturado_empresa: Empresa|null;
    facturado_cliente: Cliente|null;
    destinatario: ITabDestinatarioForm[]|null;
    observacion: ITabObservacionForm|null;
    formRemitente: Object,
    s_empresa: string | null,

}

export interface IDiligenciaProgramada{
    d_fecha_programacion: string | null | undefined;
    s_num_carta: number | null | undefined;
    s_motorizado: string | null;
    s_observacion: string | null;
}
