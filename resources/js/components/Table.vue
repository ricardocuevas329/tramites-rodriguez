<template>
    <div
        :style="'height:' + height"
        class="overflow-x-scroll rounded-lg scrollbar py-2 max-h-72"
    >
        <table class="w-full table table-xs">
            <slot></slot>
        </table>
    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "Table",
    props: {
        height: {
            required: false,
            type: String,
            default: "auto",
        },
    },
});
</script>
<style>
table tbody tr td:not(.actions) {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
}
</style>
<style scoped>
.scrollbar {
    padding-right: 3px;
}

.scrollbar::-webkit-scrollbar {
    width: 10px;
    height: 8px;
}
.scrollbar::-webkit-scrollbar-corner {
    background: oklch(var(--b1));
}
.scrollbar::-webkit-scrollbar-track {
    border-radius: 100vh;
    background: oklch(var(--b1));
}

.scrollbar::-webkit-scrollbar-thumb {
    background: oklch(var(--b3));
    border-radius: 100vh;
    /*border: 1px solid var(--color-primary);*/
}

.scrollbar::-webkit-scrollbar-thumb:hover {
    background: oklch(var(--p));
}
</style>
