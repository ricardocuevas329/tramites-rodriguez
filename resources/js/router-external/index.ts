import { createRouter, createWebHistory } from "vue-router";
import { routerAuth } from "./Auth/AuthRouter";
import { routerPermisoViaje } from "./PermisoViaje/PermisoViajeRouter";
import { checkAuth } from "@/utils/RouterUtilsExternal";
import { routerTramite } from "@/router-external/Tramite/TramiteRouter";
import { routerConsultaTramite } from "@/router-external/ConsultaTramite/ConsultaTramiteRouter";


export const routerExternal = createRouter({
    linkActiveClass: 'active',
    history: createWebHistory(),
    routes: [
        {
            path: '/:pathMatch(.*)*',
            /**@ts-ignore */
            component: () => import('@/pages/Error404.vue')
        },
        {
            beforeEnter: checkAuth,
            path: '/',
            redirect: '/Home'
        },
        {
            beforeEnter: checkAuth,
            path: '/Home',
            name: 'Home',
            props: true,
            component: () => import('@/pages/External/Home/components/Tramites.vue'),
            children: [
                ...routerTramite,
                {
                    path: '/detalle/:id/:kardex',
                    name: 'Detalle',
                    props: true,
                    component: () => import('@/pages/External/Home/components/DetalleTramite.vue'),
                    beforeEnter: checkAuth,
                    meta: {
                        showModal: true,
                        persistent: true,
                    },

                },
            ]
        },


        ...routerAuth,
        ...routerPermisoViaje,
        ...routerConsultaTramite

    ]
});
