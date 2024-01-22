<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configExtraProtocolar._LIBRO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO LIBRO</TitleTable>
                </template>
            </Head>
            <div >
                <TabForm   @OnSubmit="onSubmit" />
            </div>
        </Content>
    </ModalRouterPage>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import {
    Content,
    TitleTable,
    Head,
    ModalRouterPage,
    BtnBack,
} from "@/components";
import { notify } from "@kyvg/vue3-notification";
import { configExtraProtocolar } from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import {TabForm} from "@/pages/ExtraProtocolar/Libro/components";
import {useLibroStore} from "@/store/libro";
import {toRefs} from "vue";
import type {IFormFieldLibro} from "@/pages/ExtraProtocolar/Libro/Interfaces/libro.interface";

const router = useRouter();

const { saveLibro , listarLibros } = useLibroStore();
const {isSubmit} = toRefs(useLibroStore());

const onSubmit = async (form: IFormFieldLibro) => {
     try {
        isSubmit.value = true;

        const { status, message } = await saveLibro(form);
        if (status) {
            notify({
                title: "Exito",
                text: message,
            });
            await listarLibros();
            await router.push(configExtraProtocolar._LIBRO_.listar.path);
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>
