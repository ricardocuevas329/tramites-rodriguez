 
import {configMenu as Config} from './MenuConfig'
const routerMenus = [
    {
        ...Config._MENU_ADMINISTRACION_,
        component: () =>
            import(
                `../../pages/${Config._MENU_ADMINISTRACION_.folder}/${Config._MENU_ADMINISTRACION_.page}/${Config._MENU_ADMINISTRACION_.file}.vue`
            ),
            meta: {
                isMenu: true,
            },
    },
    {
        ...Config._MENU_EXTRAPROTOCOLAR_,
        component: () =>
            import(
                `../../pages/${Config._MENU_EXTRAPROTOCOLAR_.folder}/${Config._MENU_EXTRAPROTOCOLAR_.page}/${Config._MENU_EXTRAPROTOCOLAR_.file}.vue`
            ),
            meta: {
                isMenu: true,
            },
    },
    {
        ...Config._MENU_MANTENIMIENTO_,
        component: () =>
            import(
                `../../pages/${Config._MENU_MANTENIMIENTO_.folder}/${Config._MENU_MANTENIMIENTO_.page}/${Config._MENU_MANTENIMIENTO_.file}.vue`
            ),
            meta: {
                isMenu: true,
            },
       
    },
    {
        ...Config._MENU_PROTOCOLAR_,
        component: () =>
            import(
                `../../pages/${Config._MENU_PROTOCOLAR_.folder}/${Config._MENU_PROTOCOLAR_.page}/${Config._MENU_PROTOCOLAR_.file}.vue`
            ),
            meta: {
                isMenu: true,
            },
       
    },
    {
        ...Config._MENU_ENTIDAD_,
        component: () =>
            import(
                `../../pages/${Config._MENU_ENTIDAD_.folder}/${Config._MENU_ENTIDAD_.page}/${Config._MENU_ENTIDAD_.file}.vue`
            ),
            meta: {
                isMenu: true,
            },
       
    },
    {
        ...Config._MENU_ATU_,
        component: () =>
            import(
                `../../pages/${Config._MENU_ATU_.folder}/${Config._MENU_ATU_.page}/${Config._MENU_ATU_.file}.vue`
            ),
            meta: {
                isMenu: true,
            },
       
    },
    

    
];

export default routerMenus;
