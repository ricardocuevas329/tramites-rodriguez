<template>
   <Center>
       <div class="card  w-96 bg-base-100 py-4 md:shadow-lg px-4 md:px-8">
           <figure class="px-10 pt-10">
               <img   src="img/logo.png"
                     width="100"
                     alt=""
                     class="rounded-xl" />
           </figure>
           <div class="">
               <h1 class="text-center text-primary text-lg font-bold "> {{ configuracion?.s_empresa }}</h1>
               <p class="text-center mb-4">Ingresa tus Credenciales</p>

               <Center>
                 <Switch v-model="isCompany" text="¿Soy persona Jurídica?" />
               </Center>
               <form>
                       <TextInput
                           label="Ingrese su Correo"
                           v-model="form.email.$value"
                           :validate-error="isSubmit"
                           :error-message="form.email.$error?.message"
                       />
                       <TextInput
                           label="Ingrese su Clave"
                           v-model="form.password.$value"
                           :validate-error="isSubmit"
                           :error-message="form.password.$error?.message"
                           type="password"
                           @keyup.enter="onSubmit"
                           autocomplete="off"
                       />

                       <div class="flex items-center gap-2">
                           <input
                               id="remember"
                               aria-describedby="remember"
                               type="checkbox"
                               class="checkbox text-3xl checkbox-secondary bg-base-100 "
                               v-model="remember"
                           />

                           <label
                               for="remember"
                               class="cursor-pointer"
                           >Recordar Cuenta</label
                           >
                       </div>

                       <div class="grid my-4">
                           <BtnSave text="Ingresar" :loading="loading" :disabled="loading"
                                    @click.prevent="onSubmit"
                                    class="w-full  btn-primary "
                                    :showIcon="false"/>

                          
                       </div>


                   </form>
           </div>
       </div>
   </Center>

</template>
<script setup lang="ts">
import {BtnSave, TextInput, Center, Switch} from "@/components";
import {ref, toRefs} from "vue";
import {useRouter} from "vue-router";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as yup from "yup";
import {notify} from "@kyvg/vue3-notification";
import {useConfiguracionStore} from "@/store/configuracion";
import ServiceStorage from "@/services/LocalStorageService";
import {useAuthExternalStore} from "@/store/external/auth.external";

const {login, saveUserSesion} = useAuthExternalStore()

const loading = ref<boolean>(false);
const isSubmit = ref<boolean>(false);
const remember = ref<boolean>(false);
const isCompany = ref<boolean>(false);
const router = useRouter();
const {configuracion} = toRefs(useConfiguracionStore());
const {listarConfiguracion} = useConfiguracionStore();

const form = defineForm({
  email: field(
      "",
      yup
          .string()
          .required("es requerido")
          .email("No válido")
          .min(3, "minimo 3")
          .max(100, "máximo 100 caracteres")
  ),
  password: field(
      "",
      yup
          .string()
          .required("es requerido")
          .min(3, "minimo 3")
          .max(100, "máximo 100 caracteres")
  ),
});

const onSubmit = async () => {
  isSubmit.value = true;
  try {
    if (isValidForm(form)) {
      loading.value = true;
      const {status, message, data} = await login({ ...toObject(form),is_company: isCompany.value })
      if (status) {
        if (remember.value) {
          ServiceStorage.setKeyServiceStorage(
              "user",
              form.email.$value
          );
        }
        notify({
          title: "Bien Hecho!",
          text: message,
          type: "success",
        });
        saveUserSesion(data);
        await router.push("/");
        // listarConfiguracion();
      }

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
  form.email.$value = userStorage;
}
</script>

