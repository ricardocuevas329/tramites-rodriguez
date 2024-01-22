<template>
  <div>
    <Notification/>
          <div class=" ">
            <vue3-progress-bar></vue3-progress-bar>
            <RouterView v-slot="{ Component}">
              <component :is="Component"/>
            </RouterView>
          </div>
  </div>
</template>
<script setup lang="ts">

import {useSesionStore} from "./store/sesion";
import {useConfiguracionStore} from "./store/configuracion";
import {useRouter} from "vue-router";
import {useSidebarStore} from './store/sidebar';
import {getOSInfo} from './utils/Os';
import {onMounted} from 'vue';
import {Notification} from '@/components'

const router = useRouter()
const sesion = useSesionStore();
const {listarConfiguracion} = useConfiguracionStore()

sesion.getUserSesion();

const {hideSideBar, showSideBar} = useSidebarStore();
const {isMobile} = getOSInfo();

router.afterEach((to, from) => {
  if (isMobile) {
    if (to.meta?.isMenu) {
      hideSideBar()
    }
  } else {
    showSideBar()
  }

});


onMounted(() => {
  listarConfiguracion();
})

</script>
