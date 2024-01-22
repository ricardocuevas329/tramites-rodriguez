<template>
    <div class="mx-0 lg:mx-2 my-4 lg:my-0 ">

        <slot></slot>

    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { ModalContent } from './Index';

export default defineComponent({
    name: "Content",
    components:{ModalContent}
});
</script>
