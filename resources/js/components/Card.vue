<template>
    <div class="card my-1 w-full bg-base-100   px-2 md:px-4 py-4 "  :class="shadow && 'shadow-xl'">
        <slot></slot>
    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "Card",
    props:{
        shadow:{
            type: Boolean,
            default: false,
            required: false
        }
    }

});
</script>
