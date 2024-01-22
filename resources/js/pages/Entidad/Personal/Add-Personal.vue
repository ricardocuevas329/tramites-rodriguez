<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(configEntidad._PERSONAL_.listar.path)
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO PERSONAL</TitleTable>
                </template>
            </Head>
            <Tab :tabs="tabOptions" :icons="tabIcons">
                    <template v-slot:DatosGenerales>
                        <FormFields
                            :formValues="formValues"
                            :disabled="isSubmit"
                            @onSubmit="onSubmit"
                        />
                    </template>
                    <template v-slot:Roles>
                        <Roles
                            :formValues="formValues"
                            :disabled="isSubmit"
                            @onSubmit="onSubmit"
                        />
                    </template>
                    <template v-slot:Permisos>
                        <Permisos
                            :formValues="formValues"
                            :disabled="isSubmit"
                            @onSubmit="onSubmit"
                        />
                    </template>
            </Tab>
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
    Tab,
} from "@/components";
import { FormFields, Permisos, Roles } from "./Components/Index.js";
import { notify } from "@kyvg/vue3-notification";
import { ref } from "vue";
import { usePersonalStore } from "../../../store/personal";
import type { ITypeOptionPersonal } from "../../../models/forms/Personal";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { User } from "@/models/types";
import {InformationCircleIcon, AcademicCapIcon, UserGroupIcon} from "@heroicons/vue/20/solid";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { savePersonal, listarPersonal } = usePersonalStore();
const tabOptions = ref<ITypeOptionPersonal[]>([
    "DatosGenerales",
    "Roles",
    "Permisos"
]);

const tabIcons =  [
  InformationCircleIcon,
  AcademicCapIcon,
  UserGroupIcon
]
/**@ts-ignore */
const formValues = ref<User>({
    s_nombres:   '',
    s_nombre_seg:  '',
    s_paterno:  '',
    s_materno:   '',
    s_direccion:  '',
    s_mail:  '',
    s_user:  '',
    id_tipo_documento: '',
    s_numero:  '',
    s_distrito:  '',
    roles: [],
    permissions: [],
    s_pass:'',
    estado_civil: ''
});

const onSubmit = async (form: User) => {
    try {
        isSubmit.value = true;
        const { status, message } = await savePersonal(form);

        if (status) {
            router.push(configEntidad._PERSONAL_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarPersonal();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>
