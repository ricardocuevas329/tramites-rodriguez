<template>
  <Modal :id="idModalObservation">
    <button @click="useCloseModal()" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    <br>
    <div class="">
      <TextArea v-model="observation" :label="'Observación('+observation.length+')'"></TextArea>
      <Center>
        <BtnSave :loading="isSubmit" :disabled="isSubmit" @click="onSaveObservation()"/>
      </Center>
    </div>
  </Modal>
</template>
<script setup lang="ts">
import {useCloseModal} from "@/hooks/useUtils";
import {BtnSave, Center, Modal, TextArea} from "@/components";
import {notify} from "@kyvg/vue3-notification";
import {useLibroStore} from "@/store/libro";
import {ref, toRefs, type PropType, watchEffect,watch} from "vue";
import type {Libro} from "@/models/types";

const { isSubmit } = toRefs(useLibroStore());
const { updateObservation, listarLibros } = useLibroStore();

const props = defineProps({
  idModalObservation: {
    require: true,
    type: String,
  },
  bookSelected: {
    require: true,
    type: Object as PropType<Libro>,
  }
})

const { bookSelected } = toRefs(props)
const observation = ref<string>('');


const onSaveObservation = async () => {
  if (observation.value?.trim() != '') {

    isSubmit.value = true
    try {

      const {message, status} = await updateObservation(bookSelected.value.s_codigo, {
        observacion: observation.value
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
    observation.value = bookSelected.value?.s_observacion?.toString() ?? ''
  }
})

</script>
