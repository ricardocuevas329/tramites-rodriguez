<template>
 <div class=" w-full flex gap-1 justify-center">
    <slot></slot>
</div>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
       name: "Row",
});
</script>
