
/** MODULO Protocolar */
/** (folder) Nombre Carpeta */
const folder = "Protocolar";
/** (pages) Nombre Modulo */
const pages = {
    _TRAMITE_: "Tramite",
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
            path: `/${pages._TRAMITE_}/detalle/:id/:dni/:cod_kardex'`,
            name: `Detalle-${folder}-${pages._TRAMITE_}`,
            file: `Detalle-${pages._TRAMITE_}`,
        },
        detalleSK: {
            path: `/${pages._TRAMITE_}/detalle/:id/:dni'`,
            name: `DetalleSK-${folder}-${pages._TRAMITE_}`,
            file: `DetalleSK-${pages._TRAMITE_}`,
        },
    },
}

