<template>
    <button v-bind="$attrs" :disabled="disabled"
        class="my-1 inline-flex items-center btn btn-success text-white btn-xs">
        <PlusIcon class="h-6 w-6" />
       <slot/>
    </button>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { PlusIcon } from "@heroicons/vue/20/solid";

export default defineComponent({
    name: "BtnPush",
    props: {
        disabled: {
            default: false,
            type: Boolean,
        },
    },
    components: {
        PlusIcon,
    },
});
</script>
