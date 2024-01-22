<template>
  <Modal :id="idModalDateOpening">
    <button @click="useCloseModal()" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    <br>
    <div class="">
      <TextInput type="date" v-model="fecha" label="Fecha Apertura"/>
      <Center>
        <BtnSave :loading="isSubmit" :disabled="isSubmit" @click="onSaveObservation()"/>
      </Center>
    </div>
  </Modal>
</template>
<script setup lang="ts">
import {useCloseModal} from "@/hooks/useUtils";
import {BtnSave, Center, Modal, TextInput} from "@/components";
import {notify} from "@kyvg/vue3-notification";
import {useLibroStore} from "@/store/libro";
import {ref, toRefs, type PropType, watchEffect,watch} from "vue";
import type {Libro} from "@/models/types";
import {useDate} from "@/hooks/useDates";

const { isSubmit } = toRefs(useLibroStore());
const { updateDateOpening, listarLibros } = useLibroStore();

const props = defineProps({
  idModalDateOpening: {
    require: true,
    type: String,
  },
  bookSelected: {
    require: true,
    type: Object as PropType<Libro>,
  }
})

const { bookSelected } = toRefs(props)
const fecha = ref<string|undefined>(null);
const { formatDateFR } = useDate()

const onSaveObservation = async () => {
  if (fecha.value?.trim() != '') {

    isSubmit.value = true
    try {

      const {message, status} = await updateDateOpening(bookSelected.value.s_codigo, {
          fecha: fecha.value
      })
      if (status) {
        notify({
          title: "Exito",
          text: message,
        });
        await listarLibros();
        useCloseModal()
      }
    } catch (e) {
      isSubmit.value = false
    } finally {
      isSubmit.value = false
    }
  }

}

watchEffect(()=>{

  if(bookSelected.value){
      fecha.value = formatDateFR(bookSelected.value?.d_fecha_apertura) ?? ''
  }
})

</script>
