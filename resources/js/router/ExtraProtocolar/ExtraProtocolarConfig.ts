/** MODULO ExtraProtocolar */
/** (folder) Nombre Carpeta */
const folder = "ExtraProtocolar";
/** (pages) Nombre Modulo */

const pages = {
    _PERMISO_VIASJE_: "PermiSsoViaje",
    _PERMISO_VIAJE_: "PermisoViaje",
    _CARTA_: "Carta",
    _DILIGENCIA_CARTA_: "DiligenciaCarta",
    _LIBRO_: "Libro",
    _FIRMA_: "Firma",
    _COPIAS_CERTIFICADAS_: "CopiasCertificadas",
    _PRESENCIAS_NOTARIALES_: "PresenciasNotariales",
};

/** Configuracion de todas la rutas de este modulo */
export const configExtraProtocolar = {

    _PERMISO_VIAJE_: {
        folder: folder,
        page: pages._PERMISO_VIAJE_,
        listar: {
            path: `/${pages._PERMISO_VIAJE_}`,
            name: `List-${folder}-${pages._PERMISO_VIAJE_}`,
            file: `List-${pages._PERMISO_VIAJE_}`,
        },
        add: {
            path: `/${pages._PERMISO_VIAJE_}/add`,
            name: `Add-${folder}-${pages._PERMISO_VIAJE_}`,
            file: `Add-${pages._PERMISO_VIAJE_}`,
        },
        update: {
            path: `/${pages._PERMISO_VIAJE_}/edit/:id`,
            name: `Edit-${folder}-${pages._PERMISO_VIAJE_}`,
            file: `Edit-${pages._PERMISO_VIAJE_}`,
        },
    },
    _DILIGENCIA_CARTA_: {
        folder: folder,
        page: pages._DILIGENCIA_CARTA_,
        listar: {
            path: `/${pages._DILIGENCIA_CARTA_}`,
            name: `List-${folder}-${pages._DILIGENCIA_CARTA_}`,
            file: `List-${pages._DILIGENCIA_CARTA_}`,
        },
        add: {
            path: `/${pages._DILIGENCIA_CARTA_}/add`,
            name: `Add-${folder}-${pages._DILIGENCIA_CARTA_}`,
            file: `Add-${pages._DILIGENCIA_CARTA_}`,
        },
        new: {
            path: `/${pages._DILIGENCIA_CARTA_}/new`,
            name: `New-${folder}-${pages._DILIGENCIA_CARTA_}`,
            file: `New-${pages._DILIGENCIA_CARTA_}`,
        },
        update: {
            path: `/${pages._DILIGENCIA_CARTA_}/edit/:id`,
            name: `Edit-${folder}-${pages._DILIGENCIA_CARTA_}`,
            file: `Edit-${pages._DILIGENCIA_CARTA_}`,
        },
        view_diligencia:{
            path: `/${pages._DILIGENCIA_CARTA_}/view/:id`,
            name: `View-${folder}-${pages._DILIGENCIA_CARTA_}`,
            file: `View-${pages._DILIGENCIA_CARTA_}`,
        }
    },
    _CARTA_: {
        folder: folder,
        page: pages._CARTA_,
        listar: {
            path: `/${pages._CARTA_}`,
            name: `List-${folder}-${pages._CARTA_}`,
            file: `List-${pages._CARTA_}`,
        },
        add: {
            path: `/${pages._CARTA_}/add`,
            name: `Add-${folder}-${pages._CARTA_}`,
            file: `Add-${pages._CARTA_}`,
        },
        new: {
            path: `/${pages._CARTA_}/new`,
            name: `New-${folder}-${pages._CARTA_}`,
            file: `New-${pages._CARTA_}`,
        },
        update: {
            path: `/${pages._CARTA_}/edit/:id`,
            name: `Edit-${folder}-${pages._CARTA_}`,
            file: `Edit-${pages._CARTA_}`,
        },
        diligencia: {
            path: `/${pages._CARTA_}/diligencia/:id`,
            name: `View-${folder}-Diligencia`,
            file: `View-Diligencia`,
        },
        programacion: {
            path: `/${pages._CARTA_}/programacion/:id`,
            name: `New-${folder}-Programacion`,
            file: `New-Programacion`,
        },
        observation: {
            path: `/${pages._CARTA_}/observation/:id`,
            name: `View-${folder}-${pages._CARTA_}`,
            file: `View-Observacion`,
        },
    },
    _LIBRO_: {
        folder: folder,
        page: pages._LIBRO_,
        listar: {
            path: `/${pages._LIBRO_}`,
            name: `List-${folder}-${pages._LIBRO_}`,
            file: `List-${pages._LIBRO_}`,
        },
        add: {
            path: `/${pages._LIBRO_}/add`,
            name: `Add-${folder}-${pages._LIBRO_}`,
            file: `Add-${pages._LIBRO_}`,
        },
        update: {
            path: `/${pages._LIBRO_}/edit/:id`,
            name: `Edit-${folder}-${pages._LIBRO_}`,
            file: `Edit-${pages._LIBRO_}`,
        },
    },
    _FIRMA_: {
        folder: folder,
        page: pages._FIRMA_,
        listar: {
            path: `/${pages._FIRMA_}`,
            name: `List-${folder}-${pages._FIRMA_}`,
            file: `List-${pages._FIRMA_}`,
        },
        add: {
            path: `/${pages._FIRMA_}/add`,
            name: `Add-${folder}-${pages._FIRMA_}`,
            file: `Add-${pages._FIRMA_}`,
        },
        update: {
            path: `/${pages._FIRMA_}/edit/:id`,
            name: `Edit-${folder}-${pages._FIRMA_}`,
            file: `Edit-${pages._FIRMA_}`,
        },
        certification: {
            path: `/${pages._FIRMA_}/certification`,
            name: `Certification-${folder}-${pages._FIRMA_}`,
            file: `Certification-${pages._FIRMA_}`,
        },
        report: {
            path: `/${pages._FIRMA_}/report`,
            name: `Report-${folder}-${pages._FIRMA_}`,
            file: `Report-${pages._FIRMA_}`,
        },
    },
    _COPIAS_CERTIFICADAS_: {
        folder: folder,
        page: pages._COPIAS_CERTIFICADAS_,
        listar: {
            path: `/${pages._COPIAS_CERTIFICADAS_}`,
            name: `List-${folder}-${pages._COPIAS_CERTIFICADAS_}`,
            file: `List-${pages._COPIAS_CERTIFICADAS_}`,
        },
        add: {
            path: `/${pages._COPIAS_CERTIFICADAS_}/add`,
            name: `Add-${folder}-${pages._COPIAS_CERTIFICADAS_}`,
            file: `Add-${pages._COPIAS_CERTIFICADAS_}`,
        },
        update: {
            path: `/${pages._COPIAS_CERTIFICADAS_}/edit/:id`,
            name: `Edit-${folder}-${pages._COPIAS_CERTIFICADAS_}`,
            file: `Edit-${pages._COPIAS_CERTIFICADAS_}`,
        },
        report: {
            path: `/${pages._COPIAS_CERTIFICADAS_}/report`,
            name: `Report-${folder}-${pages._COPIAS_CERTIFICADAS_}`,
            file: `Report-${pages._COPIAS_CERTIFICADAS_}`,
        },
    },
    _PRESENCIAS_NOTARIALES_: {
        folder: folder,
        page: pages._PRESENCIAS_NOTARIALES_,
        listar: {
            path: `/${pages._PRESENCIAS_NOTARIALES_}`,
            name: `List-${folder}-${pages._PRESENCIAS_NOTARIALES_}`,
            file: `List-${pages._PRESENCIAS_NOTARIALES_}`,
        },
        report: {
            path: `/${pages._PRESENCIAS_NOTARIALES_}/report`,
            name: `Report-${folder}-${pages._PRESENCIAS_NOTARIALES_}`,
            file: `Report-${pages._PRESENCIAS_NOTARIALES_}`,
        },
    },
}


