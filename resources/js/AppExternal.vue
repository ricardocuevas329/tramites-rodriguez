<template>
   <div>
     <Notification/>
     <vue3-progress-bar></vue3-progress-bar>
     <Nav>
       <div class="w-full mt-16 ">

         <RouterView v-slot="{ Component}">
           <TransitionSlide v-if="Component">
             <component :is="Component"/>
           </TransitionSlide>
         </RouterView>
       </div>
     </Nav>
   </div>

</template>
<script setup lang="ts">
import {useConfiguracionStore} from "./store/configuracion";
import {useRoute, useRouter} from "vue-router";
import {onMounted} from 'vue';
import {Notification} from "@/components";
import {  TransitionSlide } from '@morev/vue-transitions'
import Nav from '@/pages/External/Layouts/Nav.vue'

const route = useRoute();
const router = useRouter()

const {listarConfiguracion} = useConfiguracionStore()


onMounted(() => {
    listarConfiguracion();
})

</script>
