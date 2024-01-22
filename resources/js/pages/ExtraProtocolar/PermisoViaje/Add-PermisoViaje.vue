<template>
  <ModalRouterPage>
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack
              @click="
                            router.push(
                                configExtraProtocolar._PERMISO_VIAJE_.listar
                                    .path
                            )
                        "
          />
        </template>
        <template v-slot:center>
          <TitleTable>NUEVO PERMISO DE VIAJE</TitleTable>
        </template>
      </Head>
      <TabForm :formValues="formValues" @onSubmit="onSubmit"/>
    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import {useRouter} from "vue-router";
import {BtnBack, Content, Head, ModalRouterPage, TitleTable,} from "@/components";
import {notify} from "@kyvg/vue3-notification";
import {ref, toRefs} from "vue";
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import type {PermisoViaje} from "@/models/types";
import {usePermisoViajeStore} from "@/store/permiso-viaje";
import {TabForm} from '@/pages/ExtraProtocolar/PermisoViaje/Components'

const {isSubmit} = toRefs(usePermisoViajeStore());


const router = useRouter();
const {savePermisoViaje, listarPermisoViaje} = usePermisoViajeStore();
/**@ts-ignore */
const formValues = ref<PermisoViaje>({
  i_codigo: 0,
  i_numero: null,
  i_solo: null,
  i_tipo: null,
  s_formato: "",
  s_observacion: "",
  s_ruta: "",
  s_transporte: "",
  d_fecha_ret: "",
  d_fecha_sal: "",
  s_linea: "",
  /**@ts-ignore */
  participantes: [],
  acompanantes: [],
});

const onSubmit = async (form: PermisoViaje) => {
  try {
    isSubmit.value = true;
    const {status, message} = await savePermisoViaje(form);

    if (status) {
      await router.push(configExtraProtocolar._PERMISO_VIAJE_.listar.path);
      notify({
        title: "Exito",
        text: message,
      });
      await listarPermisoViaje();
    }
  } catch (error) {
    isSubmit.value = false;
  } finally {
    setTimeout(() => {
      isSubmit.value = false;
    }, 1300);
  }
};


</script>
