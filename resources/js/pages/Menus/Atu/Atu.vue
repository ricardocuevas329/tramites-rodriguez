<template>
    <Title>ATU</Title>
    <hr class="mb-4" />
    <div

        class="w-500 grid md:grid lg:grid-cols-4 md:grid-cols-4 grid-cols-1 scrollbar-thin dark:scrollbar-thumb-gray-600 scrollbar-thumb-gray-400 dark:scrollbar-track-gray-900 hover:scrollbar-thumb-primary-400"
    >
        <ButtonItem text="Tarjeta Festiva">
            <Cog6ToothIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem text="Registro de llamadas">
            <BankIcon :size="35" />
        </ButtonItem>
        <ButtonItem text="Registro de Cartas">
            <BankIcon :size="35" />
        </ButtonItem>
    </div>
</template>
<script setup lang="ts">
import {
    Cog6ToothIcon,
} from "@heroicons/vue/20/solid";
import BankIcon from "vue-material-design-icons/Bank.vue";
import { ButtonItem, Title } from "../../../components";
import { onMounted, toRefs } from "vue";
import type { NamePermissions } from "../../../models/namesPermissions";
import { useSesionStore } from "../../../store/sesion";

const { roles, permissions } = toRefs(useSesionStore());
const { getUserSesion } = useSesionStore();

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
