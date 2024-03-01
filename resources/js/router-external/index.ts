import { createRouter, createWebHistory } from "vue-router";
import { routerAuth } from "./Auth/AuthRouter";
import { routerPermisoViaje } from "./PermisoViaje/PermisoViajeRouter";
import { checkAuth } from "@/utils/RouterUtilsExternal";
import { routerTramite } from "@/router-external/Tramite/TramiteRouter";
import { routerConsultaTramite } from "@/router-external/ConsultaTramite/ConsultaTramiteRouter";
import DetalleComponent from "@/pages/External/Home/components/DetalleTramite.vue";

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
            redirect: '/home'
        },
        {
            beforeEnter: checkAuth,
            path: '/Home',
            name: 'Home',
            component: () => import('@/pages/External/Home/Home.vue'),
            children: [
                ...routerTramite
            ]
        },
        {
            path: '/detalle/:id/:kardex',
            name: 'Detalle',
            component: DetalleComponent,
            beforeEnter: checkAuth
        },
        ...routerAuth,
        ...routerPermisoViaje,
        ...routerConsultaTramite

    ]
});
