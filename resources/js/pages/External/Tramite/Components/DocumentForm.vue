<template>
  <VirtualScrollForm :height="files?.length >= 3 ? '500px' : 'auto'">
    <div v-if="uploadFile"
         @dragover.prevent
         @dragenter.prevent
         @dragleave.prevent
         @drop="handleDrop"
         class="file-uploader bg-base-200 mb-4"
    >
      <input
          type="file"
          ref="fileInput"
          @change="handleFileChange"
          multiple
          accept="image/*,application/pdf,.docx, .xlsx"
          style="display: none"
      />
      <label for="fileInput" class="file-input-label" @click="openFileExplorer">
        Arrastra o Agrega Documentos
      </label>
    </div>
    <Table>
      <THead>
      <tr>
        <th>
          Documento
        </th>
        <th>
          Archivo
        </th>
        <th>
          Fecha Digitalizacion
        </th>
        <th>
          Personal
        </th>
        <th>

        </th>
      </tr>
      </THead>
      <tr v-if="files?.length" v-for="(file, index) in files" :key="index" class="mb-2">
        <td  >
          <p class="text-xs truncate stat-title ">{{ file.name }}</p>
        </td>
        <td>

            <div v-if="file.type.includes('image/')" class="avatar">
              <div class="w-24 rounded-xl">
                <img v-if="file?.file" :src="file?.file"/>
                <img v-else :src="file.base64"/>

              </div>
            </div>
            <div v-else class=" ">
              <div class="w-24 rounded-lg ">
                <a target="_blank" class="btn btn-success btn-outline btn-md" :href="file?.file">VER <i class=" text-error text-lg pi pi-file-pdf"></i></a>
              </div>
            </div>

        </td>
        <td>
          <p class="text-xs truncate stat-title ">{{ file?.created_at ?? '' }}</p>
        </td>
        <td class=" ">
          <p class="text-xs truncate stat-title ">{{ file.personal }}</p>

        </td>

        <td>
          <div v-if="uploadFile" class="card-actions justify-end">
            <div title="eliminar archivo">
              <button @click="deleteFile(file, index)"
                      class="btn btn-circle text-error btn-xs  btn-ghost"><i
                  class="pi pi-times"></i></button>
            </div>
          </div>
        </td>

      </tr>
      <tr v-else>
        <td>
          <p class="">No se agregaron Documentos</p>
        </td>
      </tr>
    </Table>
  </VirtualScrollForm>
</template>

<script setup lang="ts">
import {onMounted, ref, toRefs, watch} from 'vue';
import {createBase64ImageFromFile} from "@/utils/functions.js"
import {Table, THead, VirtualScrollForm} from "@/components";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {type PropType} from "vue";

const props = defineProps({
  documents: {
    default: {},
    require: false,
    type: Object as PropType<any[]>,
  },
  uploadFile: {
    default: true,
    require: false,
    type: Boolean,
  }
});
const {documents} = toRefs(props)
const fileInput = ref<any>(null);
const files = ref<IUploadFile[]>([]);

const deleteFile = async (file, index) => {
  if (file.id) {
    if (!confirm("Estas completamente seguro(a)?")) {
      return false;
    }
    /* const {status} = await axios.delete('/api/permission-travel/document/' + file.id)
     if (status !== 200) return*/
  }
  files.value.splice(index, 1)
}


const handleFileChange = async () => {
  const newFiles = Array.from(fileInput.value.files);
  files.value = [
    ...(files.value?.length ? files.value : []),
    ...(await Promise.all(
        newFiles.map(async (file) => ({
          base64: await createBase64ImageFromFile(file),
          name: file.name,
          size: file.size,
          type: file.type,
          nombre_documento: '',
          documentType: 'varios'
        }))
    )),
  ];
};

const handleDrop = async (event) => {
  event.preventDefault();
  const newFiles = Array.from(event.dataTransfer.files);
  files.value = [
    ...(files.value?.length ? files.value : []),
    ...(await Promise.all(
        newFiles.map(async (file) => ({
          base64: await createBase64ImageFromFile(file),
          name: file?.name,
          size: file?.size,
          type: file?.type,
          nombre_documento: '',
          documentType: 'varios'
        }))
    )),
  ];
};


const openFileExplorer = () => {
  fileInput.value.click();
};

onMounted(() => {
  watch(
      () => documents.value,
      (doc) => {
        files.value = doc
      }
  )
  files.value = documents.value
})

defineExpose({
  files: files
})


</script>

<style scoped>
.file-uploader {
  border: 1px dashed #ccc;
  padding: 20px;
  text-align: center;
  cursor: pointer;
  border-radius: 10px;
}

.file-input-label {
  cursor: pointer;
  display: block;
  margin-bottom: 10px;
}
</style>
