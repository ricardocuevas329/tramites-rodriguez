<template>
  <Container>
    <div>
      <Card>


        <Title>
          <button class="btn btn-xs btn-circle right-0" @click="$router.back()">
            <i class="pi pi-arrow-left"></i>
          </button>
          Nueva Presencia Notarial
        </Title>
        <div class="divider"></div>
        <ScrollView>

          <div class="text-center my-4">
            <btn-save @click="onSaveAsignationKardex" :disabled="isSubmitAction" :loading="isSubmitAction"/>
          </div>
        </ScrollView>
      </Card>
    </div>


    <router-view></router-view>
  </Container>
</template>

<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
import {
  Card,
  Container,
  ContainerTable,
  ListEmpty,
  Options,
  Paginate,
  Skeleton,
  Table,
  TextInputSearch,
  THead,
  Title,
  BtnSave,
  ScrollView
} from "@/components";
import Button from "primevue/button";
import {useCloseModal} from "@/hooks/useUtils";
import {notify} from "@kyvg/vue3-notification";
import {useKardexExternalStore} from "@/store/external/kardex.external";
import {defineForm, field, isValidForm} from "vue-yup-form";
import * as Yup from "yup";
import {validateMaxDigits} from "@/utils/Regexs";
import {useRouter} from "vue-router";
import {usePresenciaNotarialStore} from "@/store/presencia-notarial";

const {isSubmitAction, recordsKardex} = toRefs(useKardexExternalStore())
const {saveAsignationKardex, listKardexActives} = useKardexExternalStore()
const {listarPresenciaNotarial, cleanPagination} = usePresenciaNotarialStore();



const idSelected = ref<string>('')

const form = defineForm({
  cod_tramite: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  num_kardex: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => Number.isNaN(value) ? null : value)
          .test("maxDigits", "Máximo de 15 dígitos permitidos.", value => {
            return validateMaxDigits(value, 15)
          })
          .positive("Numero no Válido")
          .nullable()
  )
});



const onSaveAsignationKardex = async () => {
  if (isValidForm(form)) {
    try {
      isSubmitAction.value = true
      const {status, message} = await saveAsignationKardex({
        cod_client: idSelected.value,
        codigo: form.cod_tramite.$value,
        number_kardex: form.num_kardex.$value,
      })
      if (status) {
        isSubmitAction.value = false
        notify({
          title: message,
          type: 'success'
        })
        listarPresenciaNotarial()
        useCloseModal()
        cleanFormAssign()
      }
    } catch (e) {
      isSubmitAction.value = false
    } finally {
      isSubmitAction.value = false
    }
  }

}

const cleanFormAssign = async () => {
  form.num_kardex.$value = null
  form.cod_tramite.$value = ""
}


onMounted(() => {

});
</script>

<style scoped>

</style>
