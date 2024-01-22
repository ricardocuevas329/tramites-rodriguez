<template>
    <ScrollForm>
        <embed :src="pdf" type="application/pdf" width="100%" height="800px"/>
    </ScrollForm>
</template>
<script lang="ts">
import {defineComponent} from "vue";
import ScrollForm from "@/components/ScrollForm.vue";

export default defineComponent({
    name: "PdfView",
    components: {ScrollForm},
    props: {
        pdf: {
            type: String,
            required: true
        },
    },
});
</script>
