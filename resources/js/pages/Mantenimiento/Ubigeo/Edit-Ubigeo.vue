<template>
    <ModalRouterPage>
        <Content>

            <Head>
                <template v-slot:start>
                    <BtnBack :size="30" class="cursor-pointer"
                        @click="router.push(configMantenimiento._UBIGEO_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR UBIGEO</TitleTable>
                </template>

            </Head>


          <TabForm/>
            <div class="pb-10  py-4 px-4">



            </div>
        </Content>
    </ModalRouterPage>
</template>

<script setup lang="ts">

import { useRouter, useRoute } from 'vue-router';
import { Content, TitleTable, Head, ModalRouterPage, BtnBack } from "../../../components";
import { ref } from "vue";
import type { ItypeOptionUbigeo } from '../../../models/forms/Ubigeo';
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import {TabForm} from "@/pages/Mantenimiento/Ubigeo/Components";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const options = ref<ItypeOptionUbigeo>('departamento');
const route = useRoute();
const id = route.params.id.toString()
const CodDepartamento = id.substring(0, 2)
const CodProvincia = id.substring(2, 2)
const CodDistrito = id.substring(4, 6)

</script>
