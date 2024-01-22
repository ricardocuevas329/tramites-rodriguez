<template>
    <ScrollForm>
        <div class="rounded-box">
            <Center>
                <img :src="image" alt=""/>
            </Center>
        </div>
    </ScrollForm>
</template>
<script lang="ts">
import {defineComponent} from "vue";
import Center from "./Center.vue"
import ScrollForm from "@/components/ScrollForm.vue";

export default defineComponent({
    components: {
        ScrollForm,
        Center
    },
    name: "ImageView",
    props: {
        image: {
            type: String,
            required: true
        },
    },
});
</script>
