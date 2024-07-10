<template>
    <nav class="bg-base-100 fixed z-20 w-full">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button
                        v-if="!openSidebar"
                        @click="togleSideBar"
                        class="lg:hidden mr-2 cursor-pointer p-2 rounded "
                    >
                        <svg
                            class="w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                    <svg
                        v-if="openSidebar"
                        class="lg:hidden w-0 mx-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    <RouterLink to="/" class="cursor-pointer font-bold flex items-center">
                        <img
                            v-if="configuracion?.s_ruta_logo"
                            :src="configuracion?.s_ruta_logo"
                            class="h-8 mr-2"
                            alt=""
                        />
                    </RouterLink>

                </div>

                <div class="flex items-center">
                  <button class=" btn btn-xs  hidden md:block"> <i class="pi pi-user"></i> {{ user?.nombre_compuesto }}</button>
                  <div class="navbar-start">
                    <div class="dropdown">
                      <label tabindex="0" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                      </label>
                      <ul tabindex="0"
                          class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li>
                          <router-link :to="configProtocolar._PRESENCIA_NOTARIALES_.listar.path">Presencia Notariales</router-link>
                        </li>
                        <li>
                          <router-link :to="configProtocolar._TRAMITE_.listar.path">Trámites</router-link>
                        </li>
                          <li>
                              <router-link :to="configProtocolar._PROCURADORES_.listar.path">Procuradores</router-link>
                          </li>
                      </ul>
                    </div>
                  </div>
                    <Options :default-style="true" :text="user?.s_user?.toString()">
                        <MenuItem v-slot="{ active }" @click="onLogout()">
                            <Item :active="active"> Cerrar Sesion</Item>
                        </MenuItem>
                    </Options>
                </div>
            </div>
        </div>
    </nav>

</template>
<script setup lang="ts">
import {useSesionStore} from "../store/sesion";
import {useConfiguracionStore} from "../store/configuracion";
import {onMounted, toRefs, ref} from "vue";
import {useSidebarStore} from "../store/sidebar";
import {Item, Options} from "@/components";
import {MenuItem} from "@headlessui/vue";
import {usePermisoViajeStore} from "@/store/permiso-viaje";
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";

const {configuracion} = toRefs(useConfiguracionStore());

const {user} = toRefs(useSesionStore());
const {openSidebar} = toRefs(useSidebarStore());
const {onLogout} = useSesionStore();
const {togleSideBar} = useSidebarStore();
const {listarPermisoViajeExternal} = usePermisoViajeStore();

onMounted(() => {
    listarPermisoViajeExternal()
})
</script>
