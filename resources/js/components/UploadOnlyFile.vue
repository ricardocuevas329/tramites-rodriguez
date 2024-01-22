<template>
    <div>
        <div  @click="onFileOpenAction"
            class="flex w-full items-center justify-center"
            @dragover="handleDragOver"
            @drop="handleDrop"
           
        >
            <div class="rounded-md p-1 shadow-md">
                <label class="flex flex-col items-center gap-2 cursor-pointer">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-14 w-10 fill-white stroke-primary-500"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    <span class="text-gray-600 dark:text-white font-medium">{{
                        text
                    }}</span>
                    <span class="text-gray-600 dark:text-white text-sm">{{
                       nameFile
                    }}</span>
                    <span class="text-gray-600 dark:text-white text-sm">{{
                        size
                    }}</span>
                </label>
            </div>
        </div>
        <input
            class="hidden"
            type="file"
            accept=".pdf"
            :id="id"
            @change="onChangeFile"
        />
        <input :id="idFocus" readonly class="focus:outline-none bg-base-100" />
    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { createBase64ImageFromFile, createBase64File } from '@/utils/functions';
import { useFileOpenAction } from "@/hooks/useUtils";
import { useGetOnlyFileSelected } from '../hooks/useUtils';
export default defineComponent({
  name: "UploadOnlyFile",
  props: {
    text: {
      type: String,
      default: "Subir Archivo",
    },
    name: {
      type: String,
      default: "",
    },
    size: {
      type: String,
      default: "",
    },
    id: {
      type: String,
      default: null,
      required: true
    },
    idFocus: {
      type: String,
      default: null,
      required: false
    },
  },
  data() {
     return {
         nameFile: ''
     }
  },
  methods: {
     handleDragOver(event){
      event.preventDefault();
  },
  handleDrop: async function(event){
      this.nameFile = ''
      event.preventDefault();
      const droppedFile = event.dataTransfer.files[0];
      if (droppedFile) {
       this.nameFile = droppedFile?.name  
       const file = await  createBase64ImageFromFile(droppedFile);
       this.$emit('onGetImageBase64', file)
      }
   },
  onChangeFile: async function(){
  await createBase64File(this.id).then((res: string) => {
    if (res) {
         this.nameFile = ''
         this.$emit('onGetImageBase64', res)
         let fileTmp = useGetOnlyFileSelected("comparecientebloqueadofile")
         this.nameFile = fileTmp ?  fileTmp.name.toString() : ''
    }
   });
   },
   onFileOpenAction(){
    useFileOpenAction(this.id)
   }
  },
  created() {
    this.nameFile = this.name
  }
});
</script>
