<template>
  <main class="  ">

    <div class="navbar bg-transparent flex justify-around
            backdrop-blur-md shadow-md w-full
            fixed top-0 left-0 right-0 z-10">
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
            <li v-if="status">
              <router-link to="/">Inicio</router-link>
            </li>
            <li v-if="!status">
              <router-link to="/acceder">Acceder</router-link>
            </li>
            <li v-if="status">
              <router-link to="/home">Mis Trámites</router-link>
            </li>
            <li v-if="status">
              <a @click="onLogout">Cerrar Sesión</a>
            </li>
          </ul>
        </div>
      </div>

  
       <!--
         <div class="navbar-center">
        <div class="avatar">
          <div class="w-10 rounded-xl">
            <img v-if="configuracion?.s_ruta_logo?.toString()"
                 v-lazy="{ src: configuracion?.s_ruta_logo?.toString(), loading: loadingImg, delay: 500 }"
                 alt=""/>
          </div>
        </div>
</div>
       -->

      <div class="navbar-end">

        <div v-if="status" class="flex">
          <span   class="text-sm mx-2">Bienvenido:</span>
          <button class="btn btn-outline btn-xs btn-success "> <i class="pi pi-user text-success"></i> {{ user?.nombre_compuesto }} </button>
        </div>
        <button v-if="status" class="btn btn-ghost btn-circle">
          <div class="indicator">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="badge badge-xs badge-primary indicator-item"></span>
          </div>
        </button>
      </div>
    </div>

    <slot></slot>
  </main>
</template>

<script setup lang="ts">
import {onMounted, ref, toRefs} from 'vue'
import {useAuthExternalStore} from "@/store/external/auth.external";

const {user, status} = toRefs(useAuthExternalStore())
const {getUserSesion, onLogout} = useAuthExternalStore()

const profileOpen = ref<boolean>(false)
const asideOpen = ref<boolean>(false)


const closeProfile = () => {
  profileOpen.value = false
}

onMounted(() => {
  getUserSesion()
})

</script>
<style>

</style>
