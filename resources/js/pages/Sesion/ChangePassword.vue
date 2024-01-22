<template>
    <div class="h-screen font-sans login bg-cover">
        <div
            class="container mx-auto h-full flex flex-1 justify-center items-center"
        >
            <div class="w-full max-w-lg">
                <div class="leading-loose">
                    <a
                        href="#"
                        class="flex items-center mb-6 text-2xl font-semibold text-primary dark:text-white"
                    >
                        <img
                            v-if="configuracion?.s_ruta_logo"
                            class="w-8 h-8 mr-2"
                            :src="configuracion?.s_ruta_logo"
                            alt="logo"
                        />
                        {{ configuracion?.s_empresa }}
                    </a>
                    <Card>
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1
                                class="flex text-xl font-bold leading-tight tracking-tight text-primary md:text-2xl dark:text-white"
                            >
                                Actualiza tu clave
                                <div class="mx-2 my-2">
                                    <EyeIcon
                                        v-if="showPass"
                                        @click="showPass = !showPass"
                                        class="cursor-pointer h-6 w-6 text-primary-600"
                                    />
                                    <EyeSlashIcon
                                        v-if="!showPass"
                                        @click="showPass = !showPass"
                                        class="cursor-pointer h-6 w-6 text-primary-600"
                                    />
                                </div>
                            </h1>
                            <form class="space-y-4 md:space-y-6" action="#">
                                <TextInput
                                    placeholder="cree una clave segura"
                                    name="password1"
                                    v-model="form.password1.$value"
                                    :error-message="
                                        submitted
                                            ? form.password1.$error?.message
                                            : ''
                                    "
                                    :type="showPass ? 'password' : 'text'"
                                    label="Ingresa tu clave"
                                />

                                <TextInput
                                    placeholder="repetir clave"
                                    name="password2"
                                    v-model="form.password2.$value"
                                    :error-message="
                                        submitted
                                            ? form.password2.$error?.message
                                            : ''
                                    "
                                    :type="showPass ? 'password' : 'text'"
                                    label="Repetir clave"
                                />

                                <Center>
                                    <BtnSave
                                        text="Acceder"
                                        :disabled="loading"
                                        @click.prevent="onSubmit"
                                    />
                                </Center>
                            </form>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { TextInput, Center, BtnSave, Card } from "../../components";
import { ref, toRefs } from "vue";
import axios from "axios";
import { useSesionStore } from "../../store/sesion";
import { useRouter } from "vue-router";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import * as Yup from "yup";
import { useConfiguracionStore } from "../../store/configuracion";
import LocalStorageService from "../../services/LocalStorageService";
import { RegExps } from "../../utils/Regexs";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/20/solid";
import {API_URL} from "@/config/enviroments";

const loading = ref<boolean>(false);
const router = useRouter();
const sesion = useSesionStore();
const { configuracion } = toRefs(useConfiguracionStore());
const { listarConfiguracion } = useConfiguracionStore();
const submitted = ref(false);
const showPass = ref(false);

const password1 = field(
    "",
    Yup.string()
        .required("es requerido")
        .matches(RegExps.check, "Ingrese otra combinación")
        .min(3, "minimo 3")
        .max(100, "máximo 100 caracteres")
);
const password2 = field("", () =>
    Yup.string()
        .required("es requerido")
        .min(3, "minimo 3")
        .oneOf([password1.$value], "las claves no coinciden")
);

const form = defineForm({
    password1,
    password2,
});

const onSubmit = async () => {
    submitted.value = true;

    try {
        loading.value = true;
        if (isValidForm(form)) {
            axios
                .post(API_URL +"/api/change-password", toObject(form))
                .then((res) => {
                    const rpta = res?.data;
                    if (rpta.status) {
                        LocalStorageService.clearChangePassword();
                        sesion.saveUserSesion(rpta.data);
                        router.push("/");
                        listarConfiguracion();
                    }
                })
                .catch(function (err) {});
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            loading.value = false;
        }, 1600);
    }
};
</script>
<style>
.login {
    background: url("../../assets/login/login_fond.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
