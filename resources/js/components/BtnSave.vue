<template>
    <button
        v-bind="$attrs"
        :type="type"
        class="text-white btn"
        :class="$props?.class?.toString()"
        >
        <span v-if="loading" class="loading loading-spinner"></span>
        <slot name="icon"></slot>
        <ContentSaveCheck v-if="showIcon && !$slots.icon" class="h-4 w-4" />
        {{ text }}
    </button>
</template>

<script lang="ts">
import { defineComponent, type PropType } from "vue";
import ContentSaveCheck from "vue-material-design-icons/ContentSaveCheck.vue"
export default defineComponent({
    name: "BtnSave",
    props: {
        class: {
            required: false,
            default: "btn-primary",
            type: String,
        },
        text: {
            default: "Grabar",
            type: String,
        },
        type: {
            required: false,
            default: "button",
            type: String as PropType<"submit" | "reset" | "button">,
        },
        loading: {
            required: false,
            default: false,
            type: Boolean,
        },
        showIcon: {
            required: false,
            default: true,
            type: Boolean,
        },
    },
    components: {
        ContentSaveCheck,
    },
});
</script>
