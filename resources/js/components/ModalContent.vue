<template>
    <div class="rounded-lg  bg-base-100 modal-box scrollbar-none">
     <slot></slot>
    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";


export default defineComponent({
    name: "ModalContent",
});
</script>
<style>
.modal-box{
   padding: 0.8%!important;
   width: 100%!important;
   max-width: 42rem!important;

}
</style>
