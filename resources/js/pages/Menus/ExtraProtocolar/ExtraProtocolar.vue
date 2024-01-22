<template>
  <Title>ExtraProtocolar</Title>
  <hr class="mb-4"/>
  <div
      class="w-500 grid md:grid lg:grid-cols-4 md:grid-cols-4 grid-cols-1 scrollbar-thin dark:scrollbar-thumb-gray-600 scrollbar-thumb-gray-400 dark:scrollbar-track-gray-900 hover:scrollbar-thumb-primary-400"
      v-if="roles.length || permissions.length"
  >
    <ButtonItem
        :disabled="checkPermission('Listar PermisoViaje')"
        text="Permiso de Viaje"
        :to="configExtraProtocolar._PERMISO_VIAJE_.listar.path"
    >
      <BankIcon :size="30"/>
    </ButtonItem>
    <ButtonItem
        :disabled="checkPermission('Listar Carta')"
        text="Cartas"
        :to="configExtraProtocolar._CARTA_.listar.path"
    >
      <BankIcon :size="30"/>
    </ButtonItem>
    <ButtonItem
        :disabled="checkPermission('Listar Diligencia')"
        text="Diligencias"
        :to="configExtraProtocolar._DILIGENCIA_CARTA_.listar.path"
    >
      <Mail :size="30"/>
    </ButtonItem>
    <ButtonItem
        :disabled="checkPermission('Listar Libro')"
        text="Libros"
        :to="configExtraProtocolar._LIBRO_.listar.path"
    >
      <Mail :size="30"/>
    </ButtonItem>
    <ButtonItem
        :disabled="checkPermission('Listar RegistroFirmas')"
        text="Registro de Firmas"
        :to="configExtraProtocolar._FIRMA_.listar.path"
    >
      <Mail :size="30"/>
    </ButtonItem>
    <ButtonItem

        text="Certificación de Firmas"
        :to="configExtraProtocolar._FIRMA_.certification.path"
    >
      <Certificate :size="30"/>
    </ButtonItem>
    <ButtonItem

        text="Reporte de Firmas"
        :to="configExtraProtocolar._FIRMA_.report.path"
    >
      <Mail :size="30"/>
    </ButtonItem>
    <ButtonItem
        :disabled="checkPermission('Listar CopiasCerfificadas')"
        text="Copias Certificadas"
        :to="configExtraProtocolar._COPIAS_CERTIFICADAS_.listar.path"
    >
      <Certificate :size="30"/>
    </ButtonItem>
    <ButtonItem

        text="Reportes de Copias Certificadas"
        :to="configExtraProtocolar._COPIAS_CERTIFICADAS_.report.path"
    >
      <File :size="30"/>
    </ButtonItem>
    <ButtonItem

        text="Presencias Notariales"
        :to="configExtraProtocolar._PRESENCIAS_NOTARIALES_.listar.path"
    >
      <Mail :size="30"/>
    </ButtonItem>
    <ButtonItem

        text="Reportes de Presencias Notariales"
        :to="configExtraProtocolar._PRESENCIAS_NOTARIALES_.report.path"
    >
      <File :size="30"/>
    </ButtonItem>
  </div>
</template>
<script setup lang="ts">
import BankIcon from "vue-material-design-icons/Bank.vue";
import Mail from "vue-material-design-icons/Mail.vue";
import File from "vue-material-design-icons/File.vue";
import Certificate from "vue-material-design-icons/Certificate.vue";
import {ButtonItem, Title} from "../../../components";
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import {onMounted, toRefs} from "vue";
import type {NamePermissions} from "../../../models/namesPermissions";
import {useSesionStore} from "../../../store/sesion";

const {roles, permissions} = toRefs(useSesionStore());
const {getUserSesion} = useSesionStore();

const checkPermission = (str: NamePermissions) => {
  if (!str) return;

  if (roles.value.length) {
    if (roles?.value.some((p) => p === "superadmin")) {
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
