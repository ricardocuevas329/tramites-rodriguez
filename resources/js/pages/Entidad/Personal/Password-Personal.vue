<template>
    <Modal :id="idModalPass">
        <div v-if="userSelected">
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="useCloseModal()"
                    />

                </template>
                <template v-slot:center>
                    <Title>Cambiar Clave de Acceso </Title>
                    <Title size="text-sm"> {{ userSelected?.nombre_compuesto }} </Title>
                </template>
            </Head>
            <TextInput type="password" v-model="form.password.$value"
                       :error-message="form.password.$error?.message" label="Ingrese Nueva Clave"/>
            <TextInput type="password" v-model="form.repeat_password.$value"
                       :error-message="form.repeat_password.$error?.message" label="Repetir Nueva Clave"/>

            <Center>
                <BtnSave :disabled="!isValidForm(form)" @click="onSubmit" text="Actualizar Clave">
                    <template v-slot:icon>
                        <Key/>
                    </template>
                </BtnSave>

            </Center>
        </div>
    </Modal>
</template>
<script setup lang="ts">
import {useCloseModal} from "@/hooks/useUtils";
import {BtnBack, BtnSave, Center, Head, Modal, TextInput, Title} from "@/components";
import Key from "vue-material-design-icons/Key.vue";
import {onMounted, type PropType, ref, toRefs, watch} from "vue";
import type {User} from "@/models/types";
import {notify} from "@kyvg/vue3-notification";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as Yup from "yup";
import {RegExps} from "@/utils/Regexs";

const isSubmit = ref<boolean>(false);


const props = defineProps({
    userSelected: {
        require: true,
        type: Object as PropType<User>,
    },
    idModalPass: {
        require: true,
        type: String,
    }
});

const {userSelected, idModalPass} = toRefs(props);
const user = ref<User>()
const password = field<string>(
    "", () =>
        Yup.string()
            .required("es requerido")
            .min(6, "Minimo 6 Caracteres")
            .max(20, "Máximo 20 caracteres")
            .matches(RegExps.check, "Ingrese una Clave mas compleja")
)
const repeat_password = field<string>(
    "", () =>
        Yup.string()
            .required("es requerido")
            .min(6, "Minimo 6 Caracteres")
            .max(20, "Máximo 20 caracteres")
            .oneOf([password.$value], "las claves no coinciden")
)

const form = defineForm({
    password,
    repeat_password
})

const onSubmit = () => {
    isSubmit.value = true;
    if (isValidForm(form)) {


    }
};


const changePassword = async () => {

    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    if (user.value) {

        notify({
            title: "Exito",
            text: 'message',
        });

    }


};


onMounted(() => {
    watch(userSelected, (newValue) => {
        user.value = newValue
    });
})


</script>
