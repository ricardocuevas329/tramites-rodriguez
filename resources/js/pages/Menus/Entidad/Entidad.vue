<template>
    <Title>Entidades</Title>
    <hr class="mb-4" />
    <div  v-if="roles.length || permissions.length"
        class="w-500 grid md:grid lg:grid-cols-4 md:grid-cols-4 grid-cols-1 scrollbar-thin dark:scrollbar-thumb-gray-600 scrollbar-thumb-gray-400 dark:scrollbar-track-gray-900 hover:scrollbar-thumb-primary-400"
    >
        <ButtonItem
            :disabled="checkPermission('Listar Personal')"
            text="Personal"
            :to="configEntidad._PERSONAL_.listar.path"
        >
            <BankIcon :size="30" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Cliente')"
            text="Clientes"
            :to="configEntidad._CLIENTE_.listar.path"
        >
            <UserCircleIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Empresa')"
            text="Empresas"
            :to="configEntidad._EMPRESA_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Abogado')"
            text="Abogado"
            :to="configEntidad._ABOGADO_.listar.path"
        >
            <UserGroupIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Notario')"
            text="Notario"
            :to="configEntidad._NOTARIO_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar ComparecienteBloqueado')"
            text="Comparecientes Bloqueados"
            :to="configEntidad._COMPARECIENTE_BLOQUEADO_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
    </div>
</template>
<script setup lang="ts">
import BankIcon from "vue-material-design-icons/Bank.vue";
import { ButtonItem, Title } from "../../../components";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import {
    HomeModernIcon,
    UserCircleIcon,
    UserGroupIcon,
} from "@heroicons/vue/20/solid";
import { useSesionStore } from "../../../store/sesion";
import { toRefs, onMounted } from "vue";
import type { NamePermissions } from "../../../models/namesPermissions";

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
