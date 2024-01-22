<template>
    <div class="grid grid-cols-4 md:grid-cols-3  lg:grid-cols-3 mt-2 mb-2 py-2 md:py-0">
        <div class="col-start-1 col-span-1">
            <slot name="start"></slot>
        </div>
        <div class="w-52 self-center  md:w-64 lg:w-64">
            <slot name="center"></slot>
        </div>
        <div class="justify-self-end">
            <slot name="end"></slot>
        </div>
    </div>

</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "Head",
});
</script>
