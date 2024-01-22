<template>
  <div class="overflow-x-scroll rounded-lg scrollbar overflow-y-scroll">
    <table class="table table-xs">
      <slot></slot>
    </table>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
  name: "Table",
});
</script>
<style>
table tbody tr td:not(.actions) {
  max-width: 200px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
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
  background: oklch(var(--p));
  border-radius: 100vh;
  /*border: 1px solid var(--color-primary);*/
}

.scrollbar::-webkit-scrollbar-thumb:hover {
  background: oklch(var(--p));
}
</style>
