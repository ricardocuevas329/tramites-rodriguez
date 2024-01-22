<template>
    <div>
        <form @submit.prevent="onSubmit">
            <ScrollView>

                <TextInput
                    autofocus
                    label="Nombre"
                    v-model="form.s_departamento.$value"
                    :error-message="form.s_departamento.$error?.message"
                />
            </ScrollView>

            <Center>
                <BtnSave :text="id ? 'EDITAR DEPARTAMENTO' : 'GRABAR DEPARTAMENTO'" :disabled="loading" @click="onSubmit"/>
            </Center>
        </form>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";

import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import * as yup from "yup";
import {
    BtnSave,
    Center,
    ScrollView,
    TextInput,
} from "../../../../components";
import { useDepartamentoStore } from "../../../../store/departamento";
import { useRouter } from "vue-router";
import { notify } from "@kyvg/vue3-notification";
import { useUbigeoStore } from "../../../../store/ubigeo";

const router = useRouter();
const loading = ref(false);

const { saveDepartamento, findDepartamentoById, updateDepartamento } =
    useDepartamentoStore();

const { listarUbigeo } = useUbigeoStore();

const props = defineProps({
    id: {
        required: false,
        type: String,
        default: "",
    },
});

const { id } = props;

const form = defineForm({
    s_departamento: field(
        "",
        yup
            .string()
            .required("es requerido")
            .min(3, "Minimo 3 caracteres")
            .max(100, "Máximo 100 caracteres")
    ),

});

const onSubmit = async () => {
    if (isValidForm(form)) {
        try {
            loading.value = true;
            const { status, message } = id
                ? await updateDepartamento(id, toObject(form))
                : await saveDepartamento(toObject(form));

            if (status) {
                router.push("/ubigeo");
                notify({
                    title: "Exito",
                    text: message,
                });
                await listarUbigeo();
            }
        } catch (error) {
            console.log(error);
        } finally {
            setTimeout(() => {
                loading.value = false;
            }, 1300);
        }
    }
};

const getDepartamento = async () => {
    try {
        loading.value = true;
        const { Departamento, status } = await findDepartamentoById(id);
        if (status && Departamento) {
            form.s_codigo.$value = Departamento.s_codigo;
            form.s_departamento.$value = Departamento.s_departamento ?? '';
        }
    } catch (error) {
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    if (id) {
        getDepartamento();
    }
});
</script>
