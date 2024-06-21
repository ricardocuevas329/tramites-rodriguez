import { createRouter, createWebHistory, type RouteRecordRaw } from "vue-router";
import { checkAuth, checkAuthHome } from "@/utils/RoutersUtils";
import routerProtocolar from './Protocolar/routerProtocolar';
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";

const pages = {
    dashboard: "Dashboard",
    login: "Login",
    changePassword: "ChangePassword"
};

export const RoutesNamesHome = {
    login: {
        path: `/${pages.login}`,
        name: pages.login,
    },
    dashboard: {
        path: `/`,
        name: pages.dashboard,
    },
    changePassword: {
        path: `/${pages.changePassword}`,
        name: pages.changePassword,
    }
};

const routes: Readonly<RouteRecordRaw[]> = [
    {
        beforeEnter: checkAuthHome,
        ...RoutesNamesHome.login,
        component: () =>
            import(`../pages/Sesion/${RoutesNamesHome.login.name}.vue`),

    },

    {
        ...RoutesNamesHome.changePassword,
        component: () =>
            import(
                `../pages/Sesion/${RoutesNamesHome.changePassword.name}.vue`
            ),
    }
];

export const router = createRouter({
    //saveScrollPosition: true,
    /**@ts-ignore */
    //history: createWebHistory(import.meta.env.APP_URL),
    linkActiveClass: 'active',
    history: createWebHistory(),
    routes: [
        {
            path: '/:pathMatch(.*)*',
            /**@ts-ignore */
            component: () => import('@/pages/Error404.vue')
        },
        ...routes,
        {
            beforeEnter: checkAuth,
            ...RoutesNamesHome.dashboard,
            redirect: configProtocolar._TRAMITE_.listar.path,
            component: () =>
                import(`../pages/${RoutesNamesHome.dashboard.name}.vue`),

            children: [
                ...routerProtocolar,
            ]
        },
    ]


});



