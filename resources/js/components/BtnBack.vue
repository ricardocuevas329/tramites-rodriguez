
<template>
    <button
        class="btn mx-2 btn-sm btn-circle bg-base-200 ">
        <ArrowLeft :size="25" />
    </button>
</template>

<script lang="ts">
import { defineComponent } from "vue";
/**@ts-ignore */
import ArrowLeft from 'vue-material-design-icons/ArrowLeft.vue';
export default defineComponent({
    name: "BtnBack",
    components:{
        ArrowLeft
    }

})
</script>
