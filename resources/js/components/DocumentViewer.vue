<template>
    <PdfView v-if="!extension.includes('image/') && src" :pdf="src"/>
    <ImageView v-if="extension.includes('image/') && src" :image="src"/>
</template>
<script lang="ts">
import {defineComponent} from "vue";
import PdfView from "@/components/PdfView.vue";
import ImageView from "@/components/ImageView.vue";

export default defineComponent({
    name: "DocumentViewer",
    components: {ImageView, PdfView},
    props: {
        src: {
            default: '',
            type: String,
            required: true
        },
        extension: {
            default: 'image',
            type: String,
            required: true
        }
    },
});
</script>
