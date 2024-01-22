import {checkAuth} from "@/utils/RouterUtilsExternal";

export const routerTramite = [
    {
        beforeEnter: checkAuth,
        path: '/tramite',
        name: 'tramite',
        meta: {
            showModal: true,
            persistent: true,
        },
        component: () =>
            import('@/pages/External/Tramite/Add-Tramite.vue'),

    }
]
