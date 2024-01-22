<template>
    <ContainerTable>
     <div class="overflow-auto max-h-custom p-2  overflow-x-hidden overflow-y-scroll scrollbar ">
      <slot></slot>
    </div>
  </ContainerTable>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { ContainerTable } from './Index';

export default defineComponent({
    name: "ScrollView",
    components: {ContainerTable}
});
</script>


<style scoped>
.scrollbar::-webkit-scrollbar {
 width: 7px;
 height: 5px;

}

.scrollbar::-webkit-scrollbar-track {
 border-radius: 100vh;
 background: hsl(var(--b3)  );
}

.scrollbar::-webkit-scrollbar-thumb {
 background: hsl(var(--n) / var(--tw-bg-opacity));
 border-radius: 100vh;
 /*border: 1px solid var(--color-primary);*/
}

.scrollbar::-webkit-scrollbar-thumb:hover {
 background: hsl(var(--p) / var(--tw-bg-opacity));
}
</style>
