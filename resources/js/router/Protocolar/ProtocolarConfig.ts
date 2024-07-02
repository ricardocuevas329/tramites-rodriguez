
/** MODULO Protocolar */
/** (folder) Nombre Carpeta */
const folder = "Protocolar";
/** (pages) Nombre Modulo */
const pages = {
    _TRAMITE_: "Tramite",
    _PRESENCIA_NOTARIALES_: "PresenciaNotarial",
};

/**  Configuracion de todas la rutas de este modulo */
export const configProtocolar = {
    _TRAMITE_: {
        folder: folder,
        page: pages._TRAMITE_,
        listar: {
            path: `/${pages._TRAMITE_}`,
            name: `List-${folder}-${pages._TRAMITE_}`,
            file: `List-${pages._TRAMITE_}`,
        },
        add: {
            path: `/${pages._TRAMITE_}/add`,
            name: `Add-${folder}-${pages._TRAMITE_}`,
            file: `Add-${pages._TRAMITE_}`,
        },
        update: {
            path: `/${pages._TRAMITE_}/edit/:id`,
            name: `Edit-${folder}-${pages._TRAMITE_}`,
            file: `Edit-${pages._TRAMITE_}`,
        },
        detalle: {
            path: `/${pages._TRAMITE_}/detalle/:id`,
            name: `Detalle-${folder}-${pages._TRAMITE_}`,
            file: `Detalle-${pages._TRAMITE_}`,
        },
        detalleSK: {
            path: `/${pages._TRAMITE_}/detalle/:id/:dni'`,
            name: `DetalleSK-${folder}-${pages._TRAMITE_}`,
            file: `DetalleSK-${pages._TRAMITE_}`,
        },
    },
    _PRESENCIA_NOTARIALES_: {
        folder: folder,
        page: pages._PRESENCIA_NOTARIALES_,
        listar: {
            path: `/${pages._PRESENCIA_NOTARIALES_}`,
            name: `List-${folder}-${pages._PRESENCIA_NOTARIALES_}`,
            file: `List-${pages._PRESENCIA_NOTARIALES_}`,
        },
        add: {
            path: `/${pages._PRESENCIA_NOTARIALES_}/add`,
            name: `Add-${folder}-${pages._PRESENCIA_NOTARIALES_}`,
            file: `Add-${pages._PRESENCIA_NOTARIALES_}`,
        },
        detail: {
            path: `/${pages._PRESENCIA_NOTARIALES_}/detail/:id`,
            name: `Detail-${folder}-${pages._PRESENCIA_NOTARIALES_}`,
            file: `Detail-${pages._PRESENCIA_NOTARIALES_}`,
        },
        update: {
            path: `/${pages._PRESENCIA_NOTARIALES_}/update/:id`,
            name: `Edit-${folder}-${pages._PRESENCIA_NOTARIALES_}`,
            file: `Edit-${pages._PRESENCIA_NOTARIALES_}`,
        },
    },
}

