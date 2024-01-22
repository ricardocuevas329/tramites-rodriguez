
/** MODULO MANTENIMIENTO */
/** (folder) Nombre Carpeta */
const folder = "Mantenimiento";
/** (pages) Nombre Modulo */
const pages = {
    _UBIGEO_: "Ubigeo",
    _TIPO_DOCUMENTO_: "TipoDocumento",
    _UNIDADES_: "Unidades",
    _BANCO_DEPOSITO_: "BancoDeposito",
    _SERVICIO_: "Servicio",
    _TIPO_COMPARECIENTE_: "TipoCompareciente",
    _NACIONALIDAD_: "Nacionalidad",
    _PAIS_: "Pais",
    _DOCUMENTO_VENTA_: "DocumentoVenta",
    _ZONA_REGISTRAL_: "ZonaRegistral",
    _REQUISITO_: "Requisito",
    _MODO_PAGO_: "ModoPago",
    _CARGO_PUBLICO_: "CargoPublico",
    _CARGO_: "Cargo",
    _ESTADO_: "Estado",
    _CONDICION_: "Condicion",
};



/**  Configuracion de todas la rutas de este modulo */
export const configMantenimiento = {

    _UBIGEO_: {
        folder: folder,
        page: pages._UBIGEO_,
        listar: {
            path: `/${pages._UBIGEO_}`,
            name: `List-${folder}-${pages._UBIGEO_}`,
            file: `List-${pages._UBIGEO_}`,
        },
        add: {
            path: `/${pages._UBIGEO_}/add`,
            name: `Add-${folder}-${pages._UBIGEO_}`,
            file: `Add-${pages._UBIGEO_}`,
        },
        update: {
            path: `/${pages._UBIGEO_}/edit/:id`,
            name: `Edit-${folder}-${pages._UBIGEO_}`,
            file: `Edit-${pages._UBIGEO_}`,
        },
    },
    _TIPO_DOCUMENTO_: {
        folder: folder,
        page: pages._TIPO_DOCUMENTO_,
        listar: {
            path: `/${pages._TIPO_DOCUMENTO_}`,
            name: `List-${folder}-${pages._TIPO_DOCUMENTO_}`,
            file: `List-${pages._TIPO_DOCUMENTO_}`,
        },
        add: {
            path: `/${pages._TIPO_DOCUMENTO_}/add`,
            name: `Add-${folder}-${pages._TIPO_DOCUMENTO_}`,
            file: `Add-${pages._TIPO_DOCUMENTO_}`,
        },
        update: {
            path: `/${pages._TIPO_DOCUMENTO_}/edit/:id`,
            name: `Edit-${folder}-${pages._TIPO_DOCUMENTO_}`,
            file: `Edit-${pages._TIPO_DOCUMENTO_}`,
        },
    },
    _UNIDADES_: {
        folder: folder,
        page: pages._UNIDADES_,
        listar: {
            path: `/${pages._UNIDADES_}`,
            name: `List-${folder}-${pages._UNIDADES_}`,
            file: `List-${pages._UNIDADES_}`,
        },
        add: {
            path: `/${pages._UNIDADES_}/add`,
            name: `Add-${folder}-${pages._UNIDADES_}`,
            file: `Add-${pages._UNIDADES_}`,
        },
        update: {
            path: `/${pages._UNIDADES_}/edit/:id`,
            name: `Edit-${folder}-${pages._UNIDADES_}`,
            file: `Edit-${pages._UNIDADES_}`,
        },
    },
    _BANCO_DEPOSITO_: {
        folder: folder,
        page: pages._BANCO_DEPOSITO_,
        listar: {
            path: `/${pages._BANCO_DEPOSITO_}`,
            name: `List-${folder}-${pages._BANCO_DEPOSITO_}`,
            file: `List-${pages._BANCO_DEPOSITO_}`,
        },
        add: {
            path: `/${pages._BANCO_DEPOSITO_}/add`,
            name: `Add-${folder}-${pages._BANCO_DEPOSITO_}`,
            file: `Add-${pages._BANCO_DEPOSITO_}`,
        },
        update: {
            path: `/${pages._BANCO_DEPOSITO_}/edit/:id`,
            name: `Edit-${folder}-${pages._BANCO_DEPOSITO_}`,
            file: `Edit-${pages._BANCO_DEPOSITO_}`,
        },
    },
    _SERVICIO_: {
        folder: folder,
        page: pages._SERVICIO_,
        listar: {
            path: `/${pages._SERVICIO_}`,
            name: `List-${folder}-${pages._SERVICIO_}`,
            file: `List-${pages._SERVICIO_}`,
        },
        add: {
            path: `/${pages._SERVICIO_}/add`,
            name: `Add-${folder}-${pages._SERVICIO_}`,
            file: `Add-${pages._SERVICIO_}`,
        },
        update: {
            path: `/${pages._SERVICIO_}/edit/:id`,
            name: `Edit-${folder}-${pages._SERVICIO_}`,
            file: `Edit-${pages._SERVICIO_}`,
        },
    },
    _TIPO_COMPARECIENTE_: {
        folder: folder,
        page: pages._TIPO_COMPARECIENTE_,
        listar: {
            path: `/${pages._TIPO_COMPARECIENTE_}`,
            name: `List-${folder}-${pages._TIPO_COMPARECIENTE_}`,
            file: `List-${pages._TIPO_COMPARECIENTE_}`,
        },
        add: {
            path: `/${pages._TIPO_COMPARECIENTE_}/add`,
            name: `Add-${folder}-${pages._TIPO_COMPARECIENTE_}`,
            file: `Add-${pages._TIPO_COMPARECIENTE_}`,
        },
        update: {
            path: `/${pages._TIPO_COMPARECIENTE_}/edit/:id`,
            name: `Edit-${folder}-${pages._TIPO_COMPARECIENTE_}`,
            file: `Edit-${pages._TIPO_COMPARECIENTE_}`,
        },
    },
    _NACIONALIDAD_: {
        folder: folder,
        page: pages._NACIONALIDAD_,
        listar: {
            path: `/${pages._NACIONALIDAD_}`,
            name: `List-${folder}-${pages._NACIONALIDAD_}`,
            file: `List-${pages._NACIONALIDAD_}`,
        },
        add: {
            path: `/${pages._NACIONALIDAD_}/add`,
            name: `Add-${folder}-${pages._NACIONALIDAD_}`,
            file: `Add-${pages._NACIONALIDAD_}`,
        },
        update: {
            path: `/${pages._NACIONALIDAD_}/edit/:id`,
            name: `Edit-${folder}-${pages._NACIONALIDAD_}`,
            file: `Edit-${pages._NACIONALIDAD_}`,
        },
    },
    _PAIS_: {
        folder: folder,
        page: pages._PAIS_,
        listar: {
            path: `/${pages._PAIS_}`,
            name: `List-${folder}-${pages._PAIS_}`,
            file: `List-${pages._PAIS_}`,
        },
        add: {
            path: `/${pages._PAIS_}/add`,
            name: `Add-${folder}-${pages._PAIS_}`,
            file: `Add-${pages._PAIS_}`,
        },
        update: {
            path: `/${pages._PAIS_}/edit/:id`,
            name: `Edit-${folder}-${pages._PAIS_}`,
            file: `Edit-${pages._PAIS_}`,
        },
    },
    _DOCUMENTO_VENTA_: {
        folder: folder,
        page: pages._DOCUMENTO_VENTA_,
        listar: {
            path: `/${pages._DOCUMENTO_VENTA_}`,
            name: `List-${folder}-${pages._DOCUMENTO_VENTA_}`,
            file: `List-${pages._DOCUMENTO_VENTA_}`,
        },
        add: {
            path: `/${pages._DOCUMENTO_VENTA_}/add`,
            name: `Add-${folder}-${pages._DOCUMENTO_VENTA_}`,
            file: `Add-${pages._DOCUMENTO_VENTA_}`,
        },
        update: {
            path: `/${pages._DOCUMENTO_VENTA_}/edit/:id`,
            name: `Edit-${folder}-${pages._DOCUMENTO_VENTA_}`,
            file: `Edit-${pages._DOCUMENTO_VENTA_}`,
        },
    },
    _ZONA_REGISTRAL_: {
        folder: folder,
        page: pages._ZONA_REGISTRAL_,
        listar: {
            path: `/${pages._ZONA_REGISTRAL_}`,
            name: `List-${folder}-${pages._ZONA_REGISTRAL_}`,
            file: `List-${pages._ZONA_REGISTRAL_}`,
        },
        add: {
            path: `/${pages._ZONA_REGISTRAL_}/add`,
            name: `Add-${folder}-${pages._ZONA_REGISTRAL_}`,
            file: `Add-${pages._ZONA_REGISTRAL_}`,
        },
        update: {
            path: `/${pages._ZONA_REGISTRAL_}/edit/:id`,
            name: `Edit-${folder}-${pages._ZONA_REGISTRAL_}`,
            file: `Edit-${pages._ZONA_REGISTRAL_}`,
        },
    },

    _REQUISITO_: {
        folder: folder,
        page: pages._REQUISITO_,
        listar: {
            path: `/${pages._REQUISITO_}`,
            name: `List-${folder}-${pages._REQUISITO_}`,
            file: `List-${pages._REQUISITO_}`,
        },
        add: {
            path: `/${pages._REQUISITO_}/add`,
            name: `Add-${folder}-${pages._REQUISITO_}`,
            file: `Add-${pages._REQUISITO_}`,
        },
        update: {
            path: `/${pages._REQUISITO_}/edit/:id`,
            name: `Edit-${folder}-${pages._REQUISITO_}`,
            file: `Edit-${pages._REQUISITO_}`,
        },
    },
    _MODO_PAGO_: {
        folder: folder,
        page: pages._MODO_PAGO_,
        listar: {
            path: `/${pages._MODO_PAGO_}`,
            name: `List-${folder}-${pages._MODO_PAGO_}`,
            file: `List-${pages._MODO_PAGO_}`,
        },
        add: {
            path: `/${pages._MODO_PAGO_}/add`,
            name: `Add-${folder}-${pages._MODO_PAGO_}`,
            file: `Add-${pages._MODO_PAGO_}`,
        },
        update: {
            path: `/${pages._MODO_PAGO_}/edit/:id`,
            name: `Edit-${folder}-${pages._MODO_PAGO_}`,
            file: `Edit-${pages._MODO_PAGO_}`,
        },
    },
    _CARGO_PUBLICO_: {
        folder: folder,
        page: pages._CARGO_PUBLICO_,
        listar: {
            path: `/${pages._CARGO_PUBLICO_}`,
            name: `List-${folder}-${pages._CARGO_PUBLICO_}`,
            file: `List-${pages._CARGO_PUBLICO_}`,
        },
        add: {
            path: `/${pages._CARGO_PUBLICO_}/add`,
            name: `Add-${folder}-${pages._CARGO_PUBLICO_}`,
            file: `Add-${pages._CARGO_PUBLICO_}`,
        },
        update: {
            path: `/${pages._CARGO_PUBLICO_}/edit/:id`,
            name: `Edit-${folder}-${pages._CARGO_PUBLICO_}`,
            file: `Edit-${pages._CARGO_PUBLICO_}`,
        },
    },
    _CARGO_: {
        folder: folder,
        page: pages._CARGO_,
        listar: {
            path: `/${pages._CARGO_}`,
            name: `List-${folder}-${pages._CARGO_}`,
            file: `List-${pages._CARGO_}`,
        },
        add: {
            path: `/${pages._CARGO_}/add`,
            name: `Add-${folder}-${pages._CARGO_}`,
            file: `Add-${pages._CARGO_}`,
        },
        update: {
            path: `/${pages._CARGO_}/edit/:id`,
            name: `Edit-${folder}-${pages._CARGO_}`,
            file: `Edit-${pages._CARGO_}`,
        },
    },
    _ESTADO_: {
        folder: folder,
        page: pages._ESTADO_,
        listar: {
            path: `/${pages._ESTADO_}`,
            name: `List-${folder}-${pages._ESTADO_}`,
            file: `List-${pages._ESTADO_}`,
        },
        add: {
            path: `/${pages._ESTADO_}/add`,
            name: `Add-${folder}-${pages._ESTADO_}`,
            file: `Add-${pages._ESTADO_}`,
        },
        update: {
            path: `/${pages._ESTADO_}/edit/:id`,
            name: `Edit-${folder}-${pages._ESTADO_}`,
            file: `Edit-${pages._ESTADO_}`,
        },
    },
    _CONDICION_: {
        folder: folder,
        page: pages._CONDICION_,
        listar: {
            path: `/${pages._CONDICION_}`,
            name: `List-${folder}-${pages._CONDICION_}`,
            file: `List-${pages._CONDICION_}`,
        },
        add: {
            path: `/${pages._CONDICION_}/add`,
            name: `Add-${folder}-${pages._CONDICION_}`,
            file: `Add-${pages._CONDICION_}`,
        },
        update: {
            path: `/${pages._CONDICION_}/edit/:id`,
            name: `Edit-${folder}-${pages._CONDICION_}`,
            file: `Edit-${pages._CONDICION_}`,
        },
    },

}


