<template>
  <div
      class="flex h-screen w-full items-center justify-center bg-base-300 "
  >
    <div
        class="rounded-xl  bg-base-100 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8"
    >
      <div class=" ">
        <div class="mb-8 flex flex-col items-center">
          <img

              src="img/logo.png"
              alt="logo"
              width="150"
              srcset=""
          />
          <h1 class="mb-2 text-primary text-2xl">
            {{ configuracion?.s_empresa }}
          </h1>
          <span class=" ">Ingresa tus Credenciales</span>
        </div>
        <form>
          <div class="mb-4 text-lg">
            <TextInput
                label="Usuario"
                placeholder="Ingrese su Usuario"
                v-model="form.user.$value"
                :is-submite="valid"
                :error-message="form.user?.$error?.message"
            />

          </div>

          <div class="text-lg">
              <TextInput
                  label="Clave"
                  placeholder="Ingrese su Clave"
                  v-model="form.password.$value"
                  :is-submite="valid"
                  type="password"
                  :error-message="form.password?.$error?.message"
              />


          </div>
          <div class="flex justify-center">
            <div class="flex items-center gap-2">
              <input
                  v-model="remember"
                  id="remember"
                  aria-describedby="remember"
                  type="checkbox"
                  class="w-4 h-4 border border-primary-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                  required
              />

              <label
                  for="remember">Recordar Cuenta</label
              >
            </div>
          </div>
          <div class="mt-8 flex justify-center text-lg text-black">
            <button
                type="button"
                :disabled="loading"
                @click.prevent="onSubmit"
                class="btn btn-primary"
                :class="loading&&'loading'"
            >
             <i class="pi pi-arrow-right"></i> Acceder
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import {TextInput} from "@/components";
import {ref, toRefs} from "vue";
import axios from "axios";
import {useSesionStore} from "@/store/sesion";
import {useRouter} from "vue-router";
import {defineForm, field, isValidForm} from "vue-yup-form";
import * as yup from "yup";
import {notify} from "@kyvg/vue3-notification";
import {useConfiguracionStore} from "@/store/configuracion";
import ServiceStorage from "@/services/LocalStorageService";
import {API_URL} from "@/config/enviroments";

const loading = ref<boolean>(false);
const valid = ref<boolean>(false);
const remember = ref<boolean>(false);
const router = useRouter();
const sesion = useSesionStore();
const {configuracion} = toRefs(useConfiguracionStore());
const {listarConfiguracion} = useConfiguracionStore();

const form = defineForm({
  user: field(
      "",
      yup
          .string()
          .required("es requerido")
          .min(3, "minimo 3")
          .max(25, "máximo 25 caracteres")
  ),
  password: field(
      "",
      yup
          .string()
          .required("es requerido")
          .min(3, "minimo 3")
          .max(200, "máximo 200 caracteres")
  ),
});

const onSubmit = async () => {
  valid.value = true;
  try {
    if (isValidForm(form)) {
      loading.value = true;
      axios
          .post(API_URL + "/api/login", {
            s_user: form.user.$value,
            s_pass: form.password.$value,
          })
          .then((res) => {
            const rpta = res?.data;
            if (rpta.status) {
              if (remember.value) {
                ServiceStorage.setKeyServiceStorage(
                    "user",
                    form.user.$value
                );
              }
              notify({
                title: "Bien Hecho!",
                text: rpta.message,
                type: "success",
              });
              sesion.saveUserSesion(rpta.data);
              router.push("/");
              listarConfiguracion();
            }
          })
          .then((error) => {
          });
    }
  } catch (error) {
    notify({
      title: "Intentelo Nuevamente!",
      text: "Ocurrió algo!",
      type: "warn",
    });
  } finally {
    setTimeout(() => {
      loading.value = false;
    }, 1600);
  }
};
const userStorage = ServiceStorage.getKeyServiceStorage("user");
if (userStorage != null) {
  remember.value = true;
  form.user.$value = userStorage;
}
</script>
<style>

</style>
