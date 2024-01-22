import type {Cliente, Empresa, User} from "./types"


export type Sesion = {
    token: string,
    user: User,
    action?: string
}

export type SesionExternal = {
    token: string,
    user: Cliente|Empresa,
    action?: string
}
