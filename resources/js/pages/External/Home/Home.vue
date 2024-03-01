<template>
  <div class="md:mx-5">
    <Tramites @onSelectedRow="onSelectedRow" />
    <router-view></router-view>
  </div>
</template>
<script lang="ts" setup>
import { onMounted, ref } from "vue";
import Tramites from "./components/Tramites.vue"

import { useKardexExternalStore } from "@/store/external/kardex.external";
import { useClientExternalStore } from "@/store/external/client.external";

const { listKardexActives } = useKardexExternalStore()
const { listRegisterPublic } = useClientExternalStore()

const idSelectedRow = ref<number>(0)


const onSelectedRow = async (id: number) => {
  idSelectedRow.value = id
  await listRegisterPublic(id)
}

onMounted(() => {
  listKardexActives()
})
</script>
