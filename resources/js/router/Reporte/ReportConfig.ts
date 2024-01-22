
/** MODULO REPORTES */
/** (folder) Nombre Carpeta */
const folder = "Reportes";
/** (pages) Nombre Modulo */
const pages = {
    _REPORTE_: "Reporte",
};
/** Configuracion de todas la rutas de este modulo */
export const configReporte = {
    _REPORTE_: {
        folder: folder,
        page: pages._REPORTE_,
        listar: {
            path: `/${pages._REPORTE_}`,
            name: `List-${folder}-${pages._REPORTE_}`,
            file: `List-${pages._REPORTE_}`,
        },
    },
};

