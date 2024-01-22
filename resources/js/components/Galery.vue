<template>
  <div>
    <Galleria
        v-model:visible="displayBasic"
        :value="files"
        :responsiveOptions="responsiveOptions"
        :numVisible="3"

        :circular="true"
        :fullScreen="true"
        :showItemNavigators="showItemNavigators"
        :showThumbnails="false"
    >
      <template #item="slotProps">
        <img :src="slotProps.item.file" :alt="slotProps.item.name" style="display: block;"/>
      </template>
      <template #caption="slotProps">
        <p class="text-xs text-white">{{ slotProps.item.name }}</p>
      </template>
    </Galleria>
  </div>
</template>

<script setup lang="ts">
import {onMounted, type PropType, ref, toRefs, watch} from 'vue';
import Galleria from "primevue/galleria";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {useCloseModal, useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";
import {onBeforeRouteUpdate, useRouter} from "vue-router";

const props = defineProps({
  files: {
    default: [],
    require: false,
    type: Object as PropType<IUploadFile>,
  },
  showItemNavigators: {
    default: true,
    require: false,
    type: Boolean
  }
})
const idViewerFiles = ref<string>(useGenerateKeyRandom())
const displayBasic = ref(false);
const responsiveOptions = ref([
  {
    breakpoint: '991px',
    numVisible: 4
  },
  {
    breakpoint: '767px',
    numVisible: 3
  },
  {
    breakpoint: '575px',
    numVisible: 1
  }
]);

const {files} = toRefs(props)
const router = useRouter();

const onOpen = () => {
  useOpenModal(idViewerFiles.value)
  displayBasic.value = true
}

onMounted(() => {
  onBeforeRouteUpdate((to, from, next) => {
    if (to.hash == '') {
      displayBasic.value = false;
    }
    next();
  });

  watch(displayBasic, (newVal, oldVal) => {
    if (!newVal) {
      if (window.location.hash) {
        router.back()
      }
      useCloseModal()
    }
  });

})

defineExpose({onOpen})

</script>
