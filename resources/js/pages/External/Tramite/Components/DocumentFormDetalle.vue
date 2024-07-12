<template>
  <VirtualScrollForm :height="files?.length >= 3 ? '500px' : 'auto'">
    <div v-if="uploadFile" @dragover.prevent @dragenter.prevent @dragleave.prevent @drop="handleDrop"
      class="file-uploader bg-base-200 mb-4">
      <input type="file" ref="fileInput" @change="handleFileChange" multiple accept="image/*,application/pdf,.docx, .xlsx"
        style="display: none" />
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
        <td>
          <p class="text-xs truncate stat-title ">{{ file.name }}</p>
        </td>
        <td>

          <div v-if="file.type.includes('image/')" class="avatar">
            <div class="w-24 rounded-xl">
              <img v-if="file?.file" :src="file?.file" />
              <img v-else :src="file.base64" />

            </div>
          </div>
          <div v-else class=" ">
            <div class="w-24 rounded-lg">
              <span v-if="file?.estado_clic">
                <i class="pi pi-eye custom-hover eye-icon mr-1 "></i>
              </span>
              <span v-else>
                <i class="pi pi-eye-slash custom-hover eye-slash-icon mr-1 "></i>
              </span>
              <button @click="showFileViewed(file, index)" class="btn custom-hover btn-outline btn-xs">
                VER<i class="pi pi-file"></i>
              </button>
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
          <div v-if="uploadFile && !file?.id" class="card-actions justify-end">
            <div title="eliminar archivo">
              <button @click="deleteFile(file, index)" class="btn btn-circle text-white btn-xs  btn-error"><i
                  class="pi pi-times"></i></button>
            </div>
          </div>
          <div v-if="deleteFromServer && file?.id" class="card-actions justify-end">
            <div title="eliminar archivo">
              <button :disabled="isLoadingDelete" @click="deleteFileFromServer(file, index)" class="btn btn-circle text-white btn-xs  btn-primary"><i
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
import axios from "axios";
import { onMounted, ref, toRefs, watch } from 'vue';
import { createBase64ImageFromFile } from "@/utils/functions.js"
import { Table, THead, VirtualScrollForm } from "@/components";
import type { IUploadFile } from "@/models/components/upload-file.interface";
import { type PropType } from "vue";
import { useRouter } from "vue-router";
import { useTramiteStore } from "@/store/tramite";
import { notify } from "@kyvg/vue3-notification";


const { deleteDocumentById  } = useTramiteStore()
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
  },
  deleteFromServer: {
    default: false,
    require: false,
    type: Boolean,
  }
});
const { documents, deleteFromServer, uploadFile } = toRefs(props)
const fileInput = ref<any>(null);
const files = ref<IUploadFile[]>([]);
const apiResource = "/api/external/client";
const router = useRouter()
const isLoadingDelete = ref<boolean>(false);

const deleteFile = async (file, index) => {
    if (!confirm("Estas completamente seguro(a)?")) {
      return false;
    }
  files.value.splice(index, 1)
}

const deleteFileFromServer = async (file, index) => {
  if (file.id) {
    if (!confirm("Estas completamente seguro(a)?")) {
      return false;
    }
   
    isLoadingDelete.value = true
    try {
      const {status , message} = await   deleteDocumentById(file.id)
     if (status) {
      files.value.splice(index, 1)
      notify({
        type: 'success',
        title: 'Bien Hecho',
        text: message
      })
    
     }
    } catch (error) {
      isLoadingDelete.value = false
    } finally{
      setTimeout(() => {
        isLoadingDelete.value = false
      }, 1200);
    }


  }

}




const showFileViewed = (file, index: number) => {
  try {
    window.open(file.file, "")
    axios.post(`${apiResource}/get/estado-clic`, {
      id: file.id
    })
      .then(() => {
        if(!file?.estado_clic){
          files.value[index].estado_clic = 1 
        }
      })
      .catch((error) => {
        console.error('Error en la solicitud POST:', error);
      });
  } catch (error) {
    console.error('Error fuera de la solicitud POST:', error);
  }
};

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

.custom-hover:hover {
  background-color: #006aa6 !important;
  color: white !important;
}

.custom-hover {
  border-color: #66a3d2;
  color: #66a3d2;
}

/**Colores en los eyes */
.eye-icon {
  color: #00935F
}

.eye-slash-icon {
  color: orange;
}</style>
