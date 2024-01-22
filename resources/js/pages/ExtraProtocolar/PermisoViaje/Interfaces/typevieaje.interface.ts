import type { Participante } from "@/models/types"

export type ITypeViaje =  'solo' | 'acompañado' | ''
export type ITypeTab =  'DatosGenerales' | 'Participantes' | 'Acompañantes' | 'Documentos' | 'PagoOnline'

export type IParamsDeleteParticipant = {
    index: number,
    participant: Participante
}

