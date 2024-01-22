<template>
  <Card>
    <Title>
      <BtnBack @click="$router.push(configExtraProtocolar._FIRMA_.listar.path)"/><span  class="badge badge-xs badge-error font-light text-white" v-if="formValues?.d_caducidad && formValues?.d_caducidad <= todayDefault">caducado</span> Editar Firma Registrada
    </Title>
    <span ref="refFormField"></span>
    <Skeleton v-if="isLoadingGetSignatureRepresentationById" :tipo="2"/>
    <FormFields v-if="!isLoadingGetSignatureRepresentationById" :isSubmitForm="isSubmitForm" :formValues="formValues" @onSubmit="onSubmit"/>
    <div class="flex">
      <div class="badge badge-xs badge-neutral py-2 mx-1">Registrado por:</div>
      <span class="text-xs">
      {{ register_user }}
    </span>
    </div>
    <ContainerTable v-if="SignatureRepresentation?.length">
      <br>
    <Title size="text-xs">Representacion</Title>
    <Table >
      <THead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Empresa</th>
        <th scope="col">Observacion</th>

      </tr>
      </THead>
      <tbody>
      <tr v-for="(item, index) in SignatureRepresentation" :key="index"
          class="cursor-pointer  hover:bg-base-300">
        <td>
          {{ item.s_codigo }}
        </td>
        <td>
          {{ item.cliente?.nombre_compuesto }}
        </td>
        <td>
          {{ item.s_observacion }}
        </td>
      </tr>
      </tbody>
    </Table>
    </ContainerTable>
  </Card>
</template>
<script setup lang="ts">
import {BtnBack, Card, ContainerTable, Skeleton, Table, THead, Title,} from '../../../components';
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import {onMounted, ref, watch, toRefs} from "vue";
import type {Firma} from "@/models/types";
import {useFirmaStore} from "@/store/firma";
import {notify} from "@kyvg/vue3-notification";
import {useRoute, useRouter} from "vue-router";
import {useOnScrollMoveTo} from "@/hooks/useUtils";
import {FormFields} from "@/pages/ExtraProtocolar/Firma/Components";
import {useDate} from "@/hooks/useDates";


const {updateRegistroFirma, listarRegistroFirmas, findFirmaById, getSignatureRepresentationById} = useFirmaStore();
const {SignatureRepresentation, isLoadingGetSignatureRepresentationById} = toRefs(useFirmaStore())
const router = useRouter()
const route = useRoute()
const isSubmitForm = ref<boolean>(false)
const firma_cod = ref<string>('')
const register_user = ref<string>('')
const refFormField = ref<HTMLElement>()
const formValues = ref<Firma>()
const {todayDefault} = useDate()

const onSubmit = async (form) => {

  isSubmitForm.value = true
  try {
    const {status, message} = await updateRegistroFirma(firma_cod.value, form)
    if (status) {
      notify({
        title: message,
        type: 'success'
      })
      await listarRegistroFirmas()
      await router.push(configExtraProtocolar._FIRMA_.listar.path)
    }
  } catch (e) {

  } finally {
    isSubmitForm.value = false
  }
}

const onGetFirma = async (id: string) => {
  const {status, Firma} = await findFirmaById(id)
  if (status) {
    init(Firma)
  }
}


const init = (payload: Firma) => {
  formValues.value = payload
  register_user.value = payload?.atendido?.nombre_compuesto
}


onMounted(() => {
  firma_cod.value = route.params.id.toString()
  onGetFirma(firma_cod.value);
  getSignatureRepresentationById(firma_cod.value)
  watch(
      () => route.params.id,
      (newId, oldId) => {
        if (newId && newId != oldId) {
          firma_cod.value = newId.toString()
          onGetFirma(firma_cod.value);
          getSignatureRepresentationById(firma_cod.value)
          useOnScrollMoveTo(refFormField.value)
        }
      }
  )
});

</script>
