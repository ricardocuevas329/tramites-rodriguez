/** MODULO Administracion */
/** (folder) Nombre Carpeta */
const folder = "Menus";
/** (pages) Nombre Modulo */
const pages = {
    _MENU_ADMINISTRACION_: "Administracion",
    _MENU_PROTOCOLAR_: "Protocolar",
    _MENU_EXTRAPROTOCOLAR_: "ExtraProtocolar",
    _MENU_MANTENIMIENTO_: "Mantenimiento",
    _MENU_ENTIDAD_: "Entidad",
    _MENU_ATU_: "Atu",
};

/** Configuracion de todas la rutas de este modulo */
export const configMenu = {
    _MENU_ADMINISTRACION_: {
        folder: folder,
        page: pages._MENU_ADMINISTRACION_,
        path: `/${FormatPage(pages._MENU_ADMINISTRACION_)}`,
        name: `${folder}-${pages._MENU_ADMINISTRACION_}`,
        file: `${pages._MENU_ADMINISTRACION_}`,
    },
    _MENU_PROTOCOLAR_: {
        folder: folder,
        page: pages._MENU_PROTOCOLAR_,
        path: `/${FormatPage(pages._MENU_PROTOCOLAR_)}`,
        name: `${folder}-${pages._MENU_PROTOCOLAR_}`,
        file: `${pages._MENU_PROTOCOLAR_}`,
    },
    _MENU_EXTRAPROTOCOLAR_: {
        folder: folder,
        page: pages._MENU_EXTRAPROTOCOLAR_,
        path: `/${FormatPage(pages._MENU_EXTRAPROTOCOLAR_)}`,
        name: `${folder}-${pages._MENU_EXTRAPROTOCOLAR_}`,
        file: `${pages._MENU_EXTRAPROTOCOLAR_}`,
    },
    _MENU_MANTENIMIENTO_: {
        folder: folder,
        page: pages._MENU_MANTENIMIENTO_,
        path: `/${FormatPage(pages._MENU_MANTENIMIENTO_)}`,
        name: `${folder}-${pages._MENU_MANTENIMIENTO_}`,
        file: `${pages._MENU_MANTENIMIENTO_}`,
    },
    _MENU_ENTIDAD_: {
        folder: folder,
        page: pages._MENU_ENTIDAD_,
        path: `/${FormatPage(pages._MENU_ENTIDAD_)}`,
        name: `${folder}-${pages._MENU_ENTIDAD_}`,
        file: `${pages._MENU_ENTIDAD_}`,
    },
    _MENU_ATU_: {
        folder: folder,
        page: pages._MENU_ATU_,
        path: `/${FormatPage(pages._MENU_ATU_)}`,
        name: `${folder}-${pages._MENU_ATU_}`,
        file: `${pages._MENU_ATU_}`,
    },
};

function FormatPage(str: string) {
    return str
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
}
