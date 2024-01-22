import {checkAuth} from "@/utils/RouterUtilsExternal";

export const routerPermisoViaje = [
    {
        beforeEnter: checkAuth,
        path: '/permiso-viaje',
        name: 'permiso-viaje',
        component: () =>
            import('@/pages/External/PermisoViaje/Home.vue'),

    }
]
