<template>
    <button v-bind="$attrs"
        class="btn btn-error text-white btn-xs">
        <TrashIcon class="h-4 w-6" />
        <slot/>
    </button>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { TrashIcon } from '@heroicons/vue/20/solid';

export default defineComponent({
    name: "BtnRemove",
    props: {
        disabled: {
            default: false,
            type: Boolean,
        },
    },
    components: {
        TrashIcon,
    },
});
</script>
