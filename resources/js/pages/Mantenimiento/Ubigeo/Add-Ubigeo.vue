<template>
    <ModalRouterPage>
        <Content>

            <Head>
                <template v-slot:start>
                    <BtnBack @click.native="router.push(configMantenimiento._UBIGEO_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO UBIGEO</TitleTable>
                </template>

            </Head>

             <TabForm/>
            <div class="pb-10  py-4 px-4">


            </div>
        </Content>
    </ModalRouterPage>
</template>

<script setup lang="ts">

import { useRouter } from "vue-router";
import { Content, TitleTable, Head, ModalRouterPage, BtnBack } from "../../../components";
import { ref } from "vue";
import type { ItypeOptionUbigeo } from '../../../models/forms/Ubigeo';
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import { TabForm } from "./Components"
const router = useRouter();
const isSubmit = ref<boolean>(false);
const options = ref<ItypeOptionUbigeo>('departamento');


</script>
