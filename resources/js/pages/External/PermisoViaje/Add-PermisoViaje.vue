<template>

      <div v-if="!isSucess" class="card md:mx-28  ">
        <TabForm  @onSubmit="onSubmit"/>
      </div>
      <div v-else
           class=" mx-8   p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
           role="alert">
        <div class="flex items-center">
          <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
               fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
          </svg>
          <span class="sr-only">Info</span>
          <h3 class="text-lg font-medium">Bien Hecho!</h3>
        </div>
        <div class="mt-2 mb-4 text-sm">
          SU TRÁMITE HA SIDO REGISTRADO CORRECTAMENTE! , EN BREVE UN ASESOR SE COMUNICARÁ CON USTED.
        </div>
        <div class="flex">
          <button @click="isSucess = false" type="button"
                  class="text-white bg-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 mr-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <svg class="-ml-0.5 mr-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor"
                 viewBox="0 0 20 14">
              <path
                  d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
            </svg>
            regresar al formulario
          </button>
        </div>
      </div>

</template>

<script setup lang="ts">
import {notify} from "@kyvg/vue3-notification";
import {onMounted, ref, toRefs} from "vue";
import type {PermisoViajeExternal} from "@/models/types";
import {usePermisoViajeStore} from "@/store/permiso-viaje";
import {TabForm} from './Components/Index'
import {useTipoDocumentoExternalStore} from "@/store/external/tipo-documento.external";
import {useNacionalidadExternalStore} from "@/store/external/nacionalidad.external";
import {usePermisoViajeExternalStore} from "@/store/external/permiso-viaje.external";
import {useRouter} from "vue-router";

const {isSubmit} = toRefs(usePermisoViajeStore());

const {listarTipoDocumentosActivos} = useTipoDocumentoExternalStore()
const {listarNacionalidadAll} = useNacionalidadExternalStore()
const {savePermisoViaje} = usePermisoViajeExternalStore();
const isSucess = ref<boolean>(false)
const router = useRouter()

const onSubmit = async (form: PermisoViajeExternal) => {
    try {
        isSubmit.value = true;
        const {status, message} = await savePermisoViaje(form);

        if (status) {
            isSucess.value = true
            notify({
                title: "Exito",
                text: message,
            });
            await router.push('/home')

        }
    } catch (error) {
        isSubmit.value = false;
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

onMounted(() => {
    listarTipoDocumentosActivos()
    listarNacionalidadAll()
})
</script>
