<template>
    <span  class="absolute  font-sm font-semibold  text-red-600 text-xs mt-0 mx-2">
        <slot></slot>
    </span>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "LabelError",
});
</script>
