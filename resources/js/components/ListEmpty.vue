<template>
  <div class="flex mx-4  p-4 mt-4 mb-4 text-sm   btn-info rounded-lg   " role="alert">
    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"
         xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
            clip-rule="evenodd"></path>
    </svg>
    <span class="sr-only">Info</span>
    <div>
      <span class="font-medium">No existen Datos:</span>
      <ul class="mt-1.5 ml-4 list-disc list-inside">
        <li>{{ text }}</li>
      </ul>
    </div>
  </div>
</template>
<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: "ListEmpty",
  props: {
    text: {
      type: String,
      default: "Agregue un registro con el botón Nuevo"
    }
  }
});
</script>
