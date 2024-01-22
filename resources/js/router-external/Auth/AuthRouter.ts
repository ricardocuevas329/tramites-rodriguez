import {checkAuthHome} from "@/utils/RouterUtilsExternal";

export const routerAuth = [
    {
        beforeEnter: checkAuthHome,
        path:'/acceder',
        name: 'login',
        component: () =>
            import('@/pages/External/Auth/Login.vue'),

    },
    /*{
        beforeEnter: checkAuthHome,
        path:'/registro',
        name: 'register',
        component: () =>
            import('@/pages/External/Auth/Register.vue'),

    },*/

]
