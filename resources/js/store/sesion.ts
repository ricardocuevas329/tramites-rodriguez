import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import LocalStorageService from "../services/LocalStorageService";
import type {Sesion} from "../models/Sesion";
import type {User} from "@/models/types";
import type {ResponseByEntity} from "@/models/extends";
import type {NamePermissions} from "@/models/namesPermissions";
import type {NameRoles} from "@/models/nameRoles";
import {API_URL} from "@/config/enviroments";

const idStore = "UserSesionStore";
const apiResource = API_URL;

export const useSesionStore = defineStore(idStore, () => {
    const user = ref<User>();
    const changePassword = ref<Boolean>(false);
    const status = ref<boolean>(false);
    const permissions = ref<NamePermissions[]>([])
    const roles = ref<NameRoles[]>([])

    async function getUserSesion() {
        try {
            const {
                data: {data},
            }: ResponseByEntity<User> = await axios.get(apiResource+"/api/user");
            if (data?.s_codigo) {
                user.value = data;
                roles.value = data?.roles_name;
                permissions.value = data?.permissions_name;
                status.value = true;
            }

        } catch (error) {
        }
    }

    async function saveUserSesion(payload: Sesion) {
        status.value = true;
        user.value = payload?.user;
        changePassword.value = payload?.action == "changePassword" ? true : false;
        LocalStorageService.setToken(payload?.token);
        const changePass = await LocalStorageService.getChangePassword();
        changePassword.value && changePass;
    }

    async function onLogout() {
        if (!confirm("¿Estas completamente Seguro(a)?")) {
            return;
        }
        await axios
            .post(apiResource+"/api/onLogout")
            .then(async (res) => {
                //user.value = {};
                LocalStorageService.clearToken();
                status.value = false;

                const changePass =
                    await LocalStorageService.getChangePassword();
                if (changePass) {
                    LocalStorageService.clearChangePassword();
                }
                window.location.assign("/");
            })
            .catch(() => {
                status.value = false;
            });
    }

    return {
        roles,
        permissions,
        user,
        status,
        changePassword,
        getUserSesion,
        saveUserSesion,
        onLogout,
    };
});
