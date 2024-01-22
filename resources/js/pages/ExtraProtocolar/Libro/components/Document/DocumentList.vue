<template>
  <Center>
    <div class="carousel carousel-center ">
      <div class="carousel-item mx-1" v-if="files?.length" v-for="(item , i) in files">
        <template v-if="item?.options?.file">
          <div class="relative" title="ver imagen" v-if="item.type?.includes('image/')">
            <button @click="onDeleteFile(item?.options.file)" title="eliminar"
                    class="btn btn-xs btn-circle btn-ghost absolute right-1 bg-red-500 text-white">✕
            </button>
            <img :src="item.file" alt="" class="w-24 rounded cursor-pointer" @click="viewImage(item)"/>
          </div>
          <div class="relative" title="ver documento" v-if="!item.type?.includes('image/')">
            <button @click="onDeleteFile(item?.options.file)" title="eliminar"
                    class="btn btn-xs btn-circle btn-ghost absolute right-1 bg-red-500 text-white">✕
            </button>
            <FilePdfBox :size="100" class="text-red-500 cursor-pointer" @click="viewPDF(item)"/>
          </div>
        </template>

      </div>
    </div>
  </Center>

  <Modal :id="idModal" @onCloseModal="onCloseModal">
    <template v-if="source">
      <div class="my-4">
        <div class="badge badge-ghost text-xs"><strong class="mx-1">Archivo: </strong> {{ source.name }}</div>
        <br>
        <div class="badge badge-ghost text-xs"><strong class="mx-1">Subido: </strong> {{ source.created_at }}</div>
        <button @click="onCloseModal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </div>
      <ImageView v-if="sourceType == 'image'" :image="source.file"/>
      <PdfView v-if="sourceType == 'pdf'" :pdf="source.file"/>
    </template>
  </Modal>
</template>
<script setup lang="ts">
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import type {PropType} from "vue";
import {ref} from "vue";
import {Center, ImageView, Modal, PdfView} from "@/components";
import {useCloseModal, useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";
import type {ITypeSource} from "@/models/file.interface";
import type {LibroDocument} from "@/models/types";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {useLibroStore} from "@/store/libro";


const {deleteDocument} = useLibroStore()
const idModal = useGenerateKeyRandom()
const props = defineProps({
  files: {
    default: [],
    type: Object as PropType<LibroDocument[]>,
  }
});

const {files} = props
const sourceType = ref<ITypeSource>('image')
const source = ref<LibroDocument>()
const emit = defineEmits(["onDeleteFile"]);

const viewImage = (doc: LibroDocument) => {
  sourceType.value = 'image'
  source.value = doc
  useOpenModal(idModal);
}

const viewPDF = (doc: LibroDocument) => {
  sourceType.value = 'pdf'
  source.value = doc
  useOpenModal(idModal);
}


const onCloseModal = () => {
  useCloseModal()
}

const onDeleteFile = async (doc: IUploadFile | any) => {
  if (!confirm("¿Estás completamente seguro(a)?")) {
    return;
  }
  const {status} = await deleteDocument(doc.id_primary)
  if (status) {
    emit('onDeleteFile', doc)
  }
}


</script>
