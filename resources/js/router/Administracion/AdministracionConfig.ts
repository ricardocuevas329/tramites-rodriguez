
/** MODULO Administracion */
/** (folder) Nombre Carpeta */
const folder = "Administracion";
/** (pages) Nombre Modulo */

const pages = {
    _AREAS_: "Area",
    _BANCO_: "Banco",
    _BIENES_: "Bienes",
    _TIPOCAMBIO_: "TipoCambio",
    _CONFIGURACION_: "Configuracion",
    _PROFESION_: "Profesion",
    _ACCION_: "Accion",
    _REGISTRO_DEPOSITO_: "RegistroDeposito",
    _REGISTRO_VENTA_: "RegistroVenta",
};

/** Configuracion de todas la rutas de este modulo */
export const configAdministracion = {
    _REGISTRO_VENTA_: {
        folder: folder,
        page: pages._REGISTRO_VENTA_,
        listar: {
            path: `/${pages._REGISTRO_VENTA_}`,
            name: `List-${folder}-${pages._REGISTRO_VENTA_}`,
            file: `List-${pages._REGISTRO_VENTA_}`,
        },
        add: {
            path: `/${pages._REGISTRO_VENTA_}/add`,
            name: `Add-${folder}-${pages._REGISTRO_VENTA_}`,
            file: `Add-${pages._REGISTRO_VENTA_}`,
        },
        update: {
            path: `/${pages._REGISTRO_VENTA_}/edit/:id`,
            name: `Edit-${folder}-${pages._REGISTRO_VENTA_}`,
            file: `Edit-${pages._REGISTRO_VENTA_}`,
        },
    },
    _REGISTRO_DEPOSITO_: {
        folder: folder,
        page: pages._REGISTRO_DEPOSITO_,
        listar: {
            path: `/${pages._REGISTRO_DEPOSITO_}`,
            name: `List-${folder}-${pages._REGISTRO_DEPOSITO_}`,
            file: `List-${pages._REGISTRO_DEPOSITO_}`,
        },
        add: {
            path: `/${pages._REGISTRO_DEPOSITO_}/add`,
            name: `Add-${folder}-${pages._REGISTRO_DEPOSITO_}`,
            file: `Add-${pages._REGISTRO_DEPOSITO_}`,
        },
        update: {
            path: `/${pages._REGISTRO_DEPOSITO_}/edit/:id`,
            name: `Edit-${folder}-${pages._REGISTRO_DEPOSITO_}`,
            file: `Edit-${pages._REGISTRO_DEPOSITO_}`,
        },
    },
    _AREAS_: {
        folder: folder,
        page: pages._AREAS_,
        listar: {
            path: `/${pages._AREAS_}`,
            name: `List-${folder}-${pages._AREAS_}`,
            file: `List-${pages._AREAS_}`,
        },
        add: {
            path: `/${pages._AREAS_}/add`,
            name: `Add-${folder}-${pages._AREAS_}`,
            file: `Add-${pages._AREAS_}`,
        },
        update: {
            path: `/${pages._AREAS_}/edit/:id`,
            name: `Edit-${folder}-${pages._AREAS_}`,
            file: `Edit-${pages._AREAS_}`,
        },
    },
    _BANCO_: {
        folder: folder,
        page: pages._BANCO_,
        listar: {
            path: `/${pages._BANCO_}`,
            name: `List-${folder}-${pages._BANCO_}`,
            file: `List-${pages._BANCO_}`,
        },
        add: {
            path: `/${pages._BANCO_}/add`,
            name: `Add-${folder}-${pages._BANCO_}`,
            file: `Add-${pages._BANCO_}`,
        },
        update: {
            path: `/${pages._BANCO_}/edit/:id`,
            name: `Edit-${folder}-${pages._BANCO_}`,
            file: `Edit-${pages._BANCO_}`,
        },
    },
    _BIENES_: {
        folder: folder,
        page: pages._BIENES_,
        listar: {
            path: `/${pages._BIENES_}`,
            name: `List-${folder}-${pages._BIENES_}`,
            file: `List-${pages._BIENES_}`,
        },
        add: {
            path: `/${pages._BIENES_}/add`,
            name: `Add-${folder}-${pages._BIENES_}`,
            file: `Add-${pages._BIENES_}`,
        },
        update: {
            path: `/${pages._BIENES_}/edit/:id`,
            name: `Edit-${folder}-${pages._BIENES_}`,
            file: `Edit-${pages._BIENES_}`,
        },
    },
    _TIPOCAMBIO_: {
        folder: folder,
        page: pages._TIPOCAMBIO_,
        listar: {
            path: `/${pages._TIPOCAMBIO_}`,
            name: `List-${folder}-${pages._TIPOCAMBIO_}`,
            file: `List-${pages._TIPOCAMBIO_}`,
        },
        add: {
            path: `/${pages._TIPOCAMBIO_}/add`,
            name: `Add-${folder}-${pages._TIPOCAMBIO_}`,
            file: `Add-${pages._TIPOCAMBIO_}`,
        },
        update: {
            path: `/${pages._TIPOCAMBIO_}/edit/:id`,
            name: `Edit-${folder}-${pages._TIPOCAMBIO_}`,
            file: `Edit-${pages._TIPOCAMBIO_}`,
        },
    },
    _CONFIGURACION_: {
        folder: folder,
        page: pages._CONFIGURACION_,
        listar: {
            path: `/${pages._CONFIGURACION_}`,
            name: `List-${folder}-${pages._CONFIGURACION_}`,
            file: `List-${pages._CONFIGURACION_}`,
        },
        add: {
            path: `/${pages._CONFIGURACION_}/add`,
            name: `Add-${folder}-${pages._CONFIGURACION_}`,
            file: `Add-${pages._CONFIGURACION_}`,
        },
        update: {
            path: `/${pages._CONFIGURACION_}/edit/:id`,
            name: `Edit-${folder}-${pages._CONFIGURACION_}`,
            file: `Edit-${pages._CONFIGURACION_}`,
        },
    },
    _PROFESION_: {
        folder: folder,
        page: pages._PROFESION_,
        listar: {
            path: `/${pages._PROFESION_}`,
            name: `List-${folder}-${pages._PROFESION_}`,
            file: `List-${pages._PROFESION_}`,
        },
        add: {
            path: `/${pages._PROFESION_}/add`,
            name: `Add-${folder}-${pages._PROFESION_}`,
            file: `Add-${pages._PROFESION_}`,
        },
        update: {
            path: `/${pages._PROFESION_}/edit/:id`,
            name: `Edit-${folder}-${pages._PROFESION_}`,
            file: `Edit-${pages._PROFESION_}`,
        },
    },
    _ACCION_: {
        folder: folder,
        page: pages._ACCION_,
        listar: {
            path: `/${pages._ACCION_}`,
            name: `List-${folder}-${pages._ACCION_}`,
            file: `List-${pages._ACCION_}`,
        },
        add: {
            path: `/${pages._ACCION_}/add`,
            name: `Add-${folder}-${pages._ACCION_}`,
            file: `Add-${pages._ACCION_}`,
        },
        update: {
            path: `/${pages._ACCION_}/edit/:id`,
            name: `Edit-${folder}-${pages._ACCION_}`,
            file: `Edit-${pages._ACCION_}`,
        },
    },

}


