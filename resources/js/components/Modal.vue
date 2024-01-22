<template>
    <teleport to="body">
    <div class="modal" :class="position"  :id="id" @click="$emit('onCloseModal', true)">
       <ModalContent @click.stop>
          <slot></slot>
       </ModalContent>
    </div>
    </teleport>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { ModalContent } from './Index';

export default defineComponent({
    emits: ['onCloseModal'],
    name: "Modal",
    props:{
        id: {
            default: null,
            type: String,
            required: true
        },
        position: {
            default: '',
            type: String,
            required: false
        }
    },
    components:{
        ModalContent
    }
});
</script>
