<template>
  <ScrollPanel
      :style="'width: 100%; height:' +height"
      :pt="{
         wrapper: 'overflow-hidden relative float-left h-full w-full z-[1]',
        content: 'box-border h-[calc(100%+18px)] overflow-scroll pr-[18px] pb-[18px] pl-0 pt-0 relative scrollbar-none w-[calc(100%+18px)] [&::-webkit-scrollbar]:hidden',
        barX: {
            class: [ 'relative bg-primary rounded cursor-pointer h-[6px] bottom-0 z-[2]'+ showScrollX ? ' invisible' : '', 'transition duration-[250ms] ease-linear' ]
        },
        barY: {
            class: ['relative bg-primary  rounded cursor-pointer mx-2 w-[6px] top-0 z-[2]', 'transition duration-[250ms] ease-linear']
        }

    }"
  >
    <slot></slot>
  </ScrollPanel>
</template>
<script lang="ts">
import {defineComponent} from "vue";
import ScrollPanel from 'primevue/scrollpanel';

export default defineComponent({
  name: "VirtualScrollForm",
  components: {ScrollPanel},
  props:{
    height:{
      required: false,
      type: String,
      default: '200px'
    },
    showScrollX:{
      required: false,
      type: Boolean,
      default: false
    }
  }
});
</script>

