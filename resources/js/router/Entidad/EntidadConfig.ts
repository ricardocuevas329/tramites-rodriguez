
/** MODULO Entidad */
/** (folder) Nombre Carpeta */
const folder = "Entidad";
/** (pages) Nombre Modulo */

const pages = {
    _PERSONAL_: "Personal",
    _CLIENTE_: "Cliente",
    _EMPRESA_: "Empresa",
    _ABOGADO_: "Abogado",
    _NOTARIO_: "Notario",
    _COMPARECIENTE_BLOQUEADO_: "ComparecienteBloqueado",

};

/** Configuracion de todas la rutas de este modulo */
export const configEntidad = {
    _PERSONAL_: {
        folder: folder,
        page: pages._PERSONAL_,
        listar: {
            path: `/${pages._PERSONAL_}`,
            name: `List-${folder}-${pages._PERSONAL_}`,
            file: `List-${pages._PERSONAL_}`,
        },
        add: {
            path: `/${pages._PERSONAL_}/add`,
            name: `Add-${folder}-${pages._PERSONAL_}`,
            file: `Add-${pages._PERSONAL_}`,
        },
        update: {
            path: `/${pages._PERSONAL_}/edit/:id`,
            name: `Edit-${folder}-${pages._PERSONAL_}`,
            file: `Edit-${pages._PERSONAL_}`,
        },
    },
    _CLIENTE_: {
        folder: folder,
        page: pages._CLIENTE_,
        listar: {
            path: `/${pages._CLIENTE_}`,
            name: `List-${folder}-${pages._CLIENTE_}`,
            file: `List-${pages._CLIENTE_}`,
        },
        add: {
            path: `/${pages._CLIENTE_}/add`,
            name: `Add-${folder}-${pages._CLIENTE_}`,
            file: `Add-${pages._CLIENTE_}`,
        },
        update: {
            path: `/${pages._CLIENTE_}/edit/:id`,
            name: `Edit-${folder}-${pages._CLIENTE_}`,
            file: `Edit-${pages._CLIENTE_}`,
        },
    },
    _EMPRESA_: {
        folder: folder,
        page: pages._EMPRESA_,
        listar: {
            path: `/${pages._EMPRESA_}`,
            name: `List-${folder}-${pages._EMPRESA_}`,
            file: `List-${pages._EMPRESA_}`,
        },
        add: {
            path: `/${pages._EMPRESA_}/add`,
            name: `Add-${folder}-${pages._EMPRESA_}`,
            file: `Add-${pages._EMPRESA_}`,
        },
        update: {
            path: `/${pages._EMPRESA_}/edit/:id`,
            name: `Edit-${folder}-${pages._EMPRESA_}`,
            file: `Edit-${pages._EMPRESA_}`,
        },
    },
    _ABOGADO_: {
        folder: folder,
        page: pages._ABOGADO_,
        listar: {
            path: `/${pages._ABOGADO_}`,
            name: `List-${folder}-${pages._ABOGADO_}`,
            file: `List-${pages._ABOGADO_}`,
        },
        add: {
            path: `/${pages._ABOGADO_}/add`,
            name: `Add-${folder}-${pages._ABOGADO_}`,
            file: `Add-${pages._ABOGADO_}`,
        },
        update: {
            path: `/${pages._ABOGADO_}/edit/:id`,
            name: `Edit-${folder}-${pages._ABOGADO_}`,
            file: `Edit-${pages._ABOGADO_}`,
        },
    },
    _NOTARIO_: {
        folder: folder,
        page: pages._NOTARIO_,
        listar: {
            path: `/${pages._NOTARIO_}`,
            name: `List-${folder}-${pages._NOTARIO_}`,
            file: `List-${pages._NOTARIO_}`,
        },
        add: {
            path: `/${pages._NOTARIO_}/add`,
            name: `Add-${folder}-${pages._NOTARIO_}`,
            file: `Add-${pages._NOTARIO_}`,
        },
        update: {
            path: `/${pages._NOTARIO_}/edit/:id`,
            name: `Edit-${folder}-${pages._NOTARIO_}`,
            file: `Edit-${pages._NOTARIO_}`,
        },
    },
    _COMPARECIENTE_BLOQUEADO_: {
        folder: folder,
        page: pages._COMPARECIENTE_BLOQUEADO_,
        listar: {
            path: `/${pages._COMPARECIENTE_BLOQUEADO_}`,
            name: `List-${folder}-${pages._COMPARECIENTE_BLOQUEADO_}`,
            file: `List-${pages._COMPARECIENTE_BLOQUEADO_}`,
        },
        add: {
            path: `/${pages._COMPARECIENTE_BLOQUEADO_}/add`,
            name: `Add-${folder}-${pages._COMPARECIENTE_BLOQUEADO_}`,
            file: `Add-${pages._COMPARECIENTE_BLOQUEADO_}`,
        },
        update: {
            path: `/${pages._COMPARECIENTE_BLOQUEADO_}/edit/:id`,
            name: `Edit-${folder}-${pages._COMPARECIENTE_BLOQUEADO_}`,
            file: `Edit-${pages._COMPARECIENTE_BLOQUEADO_}`,
        },
    },
}


