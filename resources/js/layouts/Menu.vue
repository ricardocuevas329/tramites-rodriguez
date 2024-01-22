<template>
    <div v-if="status" class="space-y-2 pb-2">
        <RouterLink
            :to="configProtocolar._TRAMITE_.listar.path"
            :class="
                route.name == configProtocolar._TRAMITE_.listar.name &&
                'bg-primary text-white'
            "
            class="font-normal rounded-lg flex items-center  p-2 hover:bg-primary hover:text-white group "
        >
            <FolderOpenIcon class="h-6 w-6" />
            <span class="ml-3">Trámite</span>
        </RouterLink>



        <RouterLink
            v-if="!status"
            :to="RoutesNamesHome.login.path"
            :class="route.name == RoutesNamesHome.login.name && 'bg-primary text-white'"
            class="text-base font-normal rounded-lg flex items-center p-2 hover:bg-primary hover:text-white group "
        >
            <svg
                class="w-6 h-6 dark: text-gray-700 group-hover:text-primary transition duration-75"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            <span class="ml-3">Iniciar Sesion</span>
        </RouterLink>

        <a
            @click.prevent="onLogout()"
            class="cursor-pointer font-normal rounded-lg flex items-center  p-2 hover:bg-primary hover:text-white group "
        >
            <ArrowLeftOnRectangleIcon class="h-6 w-6" />
            <span class="ml-3">Salir</span>
        </a>
    </div>
</template>
<script setup lang="ts">
import { useSesionStore } from "../store/sesion";
import { useRoute } from "vue-router";
import {
    FolderOpenIcon,
    ArrowLeftOnRectangleIcon,
} from "@heroicons/vue/20/solid";
import { RoutesNamesHome } from "../router";
import { toRefs } from "vue";
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";

const { status } = toRefs(useSesionStore());
const { onLogout } = useSesionStore();

const route = useRoute();
</script>
