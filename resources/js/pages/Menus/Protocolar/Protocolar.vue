<template>
  <Title>Protocolar</Title>
  <hr class="mb-4" />
  <div  v-if="roles.length || permissions.length"
        class="w-500 grid md:grid lg:grid-cols-4 md:grid-cols-4 grid-cols-1 scrollbar-thin dark:scrollbar-thumb-gray-600 scrollbar-thumb-gray-400 dark:scrollbar-track-gray-900 hover:scrollbar-thumb-primary-400"
  >
    <ButtonItem  :disabled="checkPermission('Listar Kardex')"  text="Kardex"  :to="configProtocolar._KARDEX_.listar.path">
      <PresentationChartLineIcon class="h-8 w-8" />
    </ButtonItem>
    <ButtonItem text="Transferencia Vehicular">
      <ComputerDesktopIcon class="h-8 w-8" />
    </ButtonItem>
    <ButtonItem text="Copias Certificadas">
      <DocumentIcon class="h-8 w-8" />
    </ButtonItem>
  </div>
</template>
<script setup lang="ts">
import {
  PresentationChartLineIcon,
  ComputerDesktopIcon,
  DocumentIcon,
} from "@heroicons/vue/20/solid";
import { ButtonItem, Title } from "../../../components";
import { useSesionStore } from "../../../store/sesion";
import { toRefs, onMounted } from "vue";
import type { NamePermissions } from "../../../models/namesPermissions";
import { configProtocolar } from "@/router/Protocolar/ProtocolarConfig";
const { roles, permissions } = toRefs(useSesionStore());
const { getUserSesion } = useSesionStore();

const checkPermission = (str: NamePermissions) => {
  if(!str) return
  if (roles.value.length) {
    if (roles?.value.some((p) => p === 'superadmin')) {
      return false;
    }
  }
  if (permissions.value.length) {
    if (permissions?.value.some((p) => p === str)) {
      return false;
    }
  }
};

onMounted(() => {
  getUserSesion();
});
</script>
