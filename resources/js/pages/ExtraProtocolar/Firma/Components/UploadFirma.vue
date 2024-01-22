<template>
  <Modal :id="idModal">

    <div class="flex">
      <BtnBack @click="useCloseModal()"/>
      <Title class="mt-1">Adjuntar Firma {{id_signature}} </Title>
    </div>
    <ScrollView>

      <UploaderFiles :files="files"  :key="keyRandom"  :multiple="false"
                     endPointDelete="/api/signature/delete-photo/" :maxFiles="MAX_TOTAL_FILES"
                     maxFileSize="15MB" @getFiles="onGetFiles"
                     maxTotalFileSize="60MB" @deleteFile="onDeleteFile"
                     accept="image/* , application/pdf"
                     label="Arrastra o Agrega la Firma en PDF/Image"/>
    </ScrollView>
    <Center>
      <BtnSave @click="submit"   :loading="isSubmit"  :disabled="isSubmit"  class="btn   btn-xs btn-primary" text="Guardar Firma">
        <template v-slot:icon>
          <ContentSave class="w-4"/>
        </template>
      </BtnSave>
    </Center>
  </Modal>
</template>
<script setup lang="ts">
import {useCloseModal, useGenerateKeyRandom} from "@/hooks/useUtils";
import {BtnBack, BtnSave, Center, Modal, ScrollView, Title, UploaderFiles} from "@/components";
import ContentSave from "vue-material-design-icons/ContentSave.vue";
import {ref, onMounted, toRefs} from "vue";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {useFirmaStore} from "@/store/firma";
import {notify} from "@kyvg/vue3-notification";


const { uploadPhotoSignature, listarRegistroFirmas } = useFirmaStore()
const props = defineProps({
  idModal: {
    required: true,
    type: String,
  },
  id_signature: {
    required: true,
    type: String,
  },
  source: {
    required: false,
    type: String,
  }
})

const {id_signature, source} = toRefs(props)
const files = ref<IUploadFile[]>([])
const MAX_TOTAL_FILES = 1
const isSubmit = ref<boolean>(false)
const keyRandom = ref<string>('')


const onDeleteFile = (doc: IUploadFile) => {
  keyRandom.value = useGenerateKeyRandom()
}

const onGetFiles = (doc: IUploadFile[]) => {
  files.value = doc?.value
}

const submit = async() => {

  if(files.value.length){

    try {
      isSubmit.value = true
      const { status, message } = await uploadPhotoSignature(id_signature.value, {
        foto_firma: files.value[0].base64 ?? ''
      })
      if(status){
        notify({
          title: message,
          type: 'success'
        })
        listarRegistroFirmas()
        keyRandom.value = useGenerateKeyRandom()
        files.value = []
        useCloseModal()

      }
    }catch (e) {

    } finally {
      setTimeout(()=>{
        isSubmit.value = false
      }, 1300)
    }

  }
}


onMounted(()=>{
  keyRandom.value = id_signature.value
  files.value = []
})
</script>
