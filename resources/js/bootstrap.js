/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import { useProgress } from '@marcoschulte/vue3-progress';
import axios from 'axios';
import LocalStorageService from './services/LocalStorageService';
import { notify } from '@kyvg/vue3-notification';
import {RoutesNamesHome} from './router/index'

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const progresses = [];

axios.interceptors.request.use(
    config => {
        progresses.push(useProgress().start());
        let token = LocalStorageService.getAccessToken()
        if (token) {
            config.headers["Authorization"] = "Bearer " + token;
        }

        return config;
    },
    error => {
        progresses.pop()?.finish();
        Promise.reject(error);
    }
);

axios.interceptors.response.use(
    response => {
        progresses.pop()?.finish();
        return response;
    },
    function (error) {
        progresses.pop()?.finish();
        const originalRequest = error.config;
        if (error?.response?.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;
            LocalStorageService.clearToken()
            if(location.pathname!= RoutesNamesHome.login.path){
               window.location = RoutesNamesHome.login.path
            }
            return;
        }

        if (error?.response?.status === 421) {
            if (error.response ) {
                let errores = error.response.data
                    notify({
                        title: "Atención!",
                        text: errores.message,
                        type: "warn",
                    });

            }
            return
        }

        if (error?.response?.status === 403) {
            if (error.response ) {
                let errores = error.response.data
                    notify({
                        title: "Atención!",
                        text: "No cuenta con Permisos Necesarios!",
                        type: "warn",
                    });

            }
            return
        }

        if (error?.response?.status === 429) {
            if (error.response ) {
                    notify({
                        title: "Atención!",
                        text: "Espere un momento e Intente Nuvamente!",
                        type: "warn",
                    });

            }
            return
        }

        if (error?.response?.status === 422) {
            let message = ""
            if (error.response.data.errors) {
                let errores = error.response.data.errors
                if (Object.keys(errores)) {
                    let nameProperty = Object.getOwnPropertyNames(errores)[0]
                    return  notify({
                        title: "Intentelo Nuevamente!",
                        text: errores[nameProperty][0],
                        type: "warn",
                    });

                }
            }
            if (error.response ) {
                let errores = error.response.data
                return notify({
                    title: "Atención!",
                    text: errores.message,
                    type: "warn",
                });

            }


        }

    }
);
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
