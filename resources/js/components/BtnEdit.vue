<template>
    <RouterLink :to="path">
        <button
            class="btn btn-primary  font-medium text-sm px-5 py-3 text-center inline-flex items-center mr-2 "
        >
            <PencilIcon :size="25" fillColor="#FFFFFF" /> {{ text }}
        </button>
    </RouterLink>
</template>
<script lang="ts">
import { defineComponent } from "vue";
/**@ts-ignore */
import PencilIcon from 'vue-material-design-icons/Pencil.vue';
 
export default defineComponent({
    components:{
        PencilIcon
    },
    name: "BtnEdit",
    props: {
        text: {
            default: "Editar Registro",
            type: String,
        },
        path: {
            default: "/",
            type: String,
        },
    },
});
</script>
