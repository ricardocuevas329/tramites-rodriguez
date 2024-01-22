import type {PermisoViajeDocument, PermisoViajeParticipantExternal} from "@/models/types"


export type ILineaPermisoViaje = 'TERRESTRE' | 'AEREA' | 'MARITIMA'
export type ITypeViaje =  'solo' | 'acompañado' | ''
export type ITypeTab =  'DatosGenerales' | 'Participantes' | 'Documentos'

export type IParamsDeleteParticipant = {
    index: number,
    participant: PermisoViajeParticipantExternal
}

export interface IPermisoViajeExternalFormModel {
    travel: string|null
    date_ret: string
    date_sal: string|null
    rol: number|null
    type: number|null
    format: number|null
    line: string
    obervation: string|null
    route: string
    transport: number|null
    participantes: PermisoViajeParticipantExternal[]
    files: PermisoViajeDocument[]
    phone: number|null
    email: string
}
