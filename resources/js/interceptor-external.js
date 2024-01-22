/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import { useProgress } from '@marcoschulte/vue3-progress';
import axios from 'axios';
import { notify } from '@kyvg/vue3-notification';
import LocalStorageService from "./services/LocalStorageService";
import {RoutesNamesHome} from "@/router";

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
            /*  originalRequest._retry = true;
             LocalStorageService.clearToken()
            if(location.pathname!= '/acceder'){
                 window.location = '/acceder'
             }
             return;*/
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
                    return notify({
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
