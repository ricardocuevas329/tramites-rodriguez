<template>
    <button :class="[
        active
            ? 'btn-primary  '
            : 'bg-base-200',
        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
    ]">
        <slot />
    </button>
</template>
<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "Item",
    props: {
        active: {
            type: Boolean,
            default: false,
        },
    },
});
</script>
