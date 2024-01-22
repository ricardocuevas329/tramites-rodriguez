import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Cliente, Empresa} from "@/models/types";
import type {ResponseByEntity} from "@/models/extends";
import type {SesionExternal} from "@/models/Sesion";
import LocalStorageService from "@/services/LocalStorageService";

const idStore = "AuthExternalStore";
const apiResource = "/api/external/auth";

export const useAuthExternalStore = defineStore(idStore, () => {
    const user = ref<Cliente | Empresa>();
    const status = ref<boolean>(false);

    async function getUserSesion() {
        try {
            const {
                data: {data},
            }: ResponseByEntity<Cliente | Empresa> = await axios.get(`${apiResource}/user`);
            if (data?.s_codigo) {
                user.value = data;
                status.value = true;
            }
        } catch (error) {
        }
    }

    async function register(payload) {
        try {
            const {
                data: {data, status, message},
            }: ResponseByEntity<Cliente | Empresa> = await axios.post(
                `${apiResource}/register`, payload
            );
            return {
                data,
                status,
                message
            }
        } catch (error) {
        } finally {
        }
    }

    async function login(payload) {
        try {
            const {
                data: {data, status, message},
            }: ResponseByEntity<Cliente | Empresa> = await axios.post(
                `${apiResource}/login`, payload
            );
            return {
                data,
                status,
                message
            }
        } catch (error) {
        } finally {
        }
    }

    function saveUserSesion(payload: SesionExternal) {
        status.value = true;
        user.value = payload?.user;
        LocalStorageService.setToken(payload?.token);
    }

    async function onLogout() {
        if (!confirm("¿Estas completamente Seguro(a)?")) {
            return;
        }
        await axios
            .post(`${apiResource}/logout`)
            .then(async (res) => {
                LocalStorageService.clearToken();
                status.value = false;
                window.location.assign("/");
            })
            .catch(() => {
                status.value = false;
            });
    }

    return {
        user,
        register,
        login,
        saveUserSesion,
        status,
        onLogout,
        getUserSesion
    };
});
