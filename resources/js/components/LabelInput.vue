<template>
    <label
        class="mx-2 block  relative  w-40 text-xs font-bold mb-1" :class="!full && 'truncate'"
    >
      <slot></slot>
    </label>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "LabelInput",
    props:{
      full:{
        type: Boolean,
        default: false,
        required: false
      }
    }
});
</script>
