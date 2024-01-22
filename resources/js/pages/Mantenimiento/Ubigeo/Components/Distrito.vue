<template>
    <div>

        <form @submit.prevent="onSubmit">
            <ScrollView>
                <fieldset class="InputGroup" v-for="(item, i) in form.distritos.$forms" :key="item.$key">

                    <Head v-if="form.distritos.$forms.length > 1">

                        <template v-slot:end>
                            <BtnRemove type="button"
                                @click="form.distritos.$remove(i)">
                                Eliminar
                            </BtnRemove>
                        </template>

                    </Head>

                    <InputSelect @change="onChangeDepartamento(item.departamento.$value, i)"
                        :items="allDepartaments" label="Departamentos"
                        v-model="item.departamento.$value" :id="`name_${item.$key}`" :name="`name_${item.$key}`"
                        :error-message="item.departamento.$error?.message" label-data="s_departamento"
                        value-data="s_codigo" />

                    <InputSelect :items="Provincias" label="Provincia" v-model="item.provincia.$value"
                        :id="`name_${item.$key}`" :name="`name_${item.$key}`"
                        :error-message="item.provincia.$error?.message" label-data="s_provincia"
                        value-data="s_codigo" />

                    <TextInput autofocus label="Nombre" v-model="item.s_distrito.$value" :id="`name_${item.$key}`"
                        :name="`name_${item.$key}`" :error-message="item.s_distrito.$error?.message" />
                </fieldset>
            </ScrollView>

            <div class="flex ml-3 lg:ml-6">
                <BtnPush type="button" :disabled="!isValidForm(form)"  @click="isValidForm(form) && form.distritos.$append()">
                   Agregar
                </BtnPush>
            </div>

          <Center>
            <BtnSave :text="id ? 'EDITAR DISTRITO' : 'GRABAR DISTRITO'" :disabled="loading" @click="onSubmit"/>
          </Center>
        </form>


    </div>
</template>

<script lang="ts" setup>
import {ref, toRefs} from 'vue';
import {
    defineForm,
    field,
    formsField,
    isValidForm,
    toObject,
} from "vue-yup-form";
import * as yup from "yup";
import { BtnPush, BtnRemove, BtnSave, Center, Head, InputSelect, ScrollView, TextInput } from '../../../../components';
import { useDepartamentoStore } from '../../../../store/departamento';
import { useProvinciaStore } from '../../../../store/provincia';
import { useDistritoStore } from '../../../../store/distrito';
import { useUbigeoStore } from '../../../../store/ubigeo';
import { useRouter } from 'vue-router';
import { notify } from '@kyvg/vue3-notification';

const loading = ref(false);
const {getAllDepartament} = useDepartamentoStore()
const {allDepartaments} = toRefs(useDepartamentoStore())
const storeDepartamento = useDepartamentoStore()
const { listarProvincia  } = useProvinciaStore()
const { Provincias  } = toRefs(useProvinciaStore())
const { saveDistrito  } = useDistritoStore()
const {listarUbigeo} = useUbigeoStore()
const router = useRouter();

const props = defineProps({
    id: {
        required: false,
        type: String,
        default: '',
    }
});

const { id } = props


const generateDistritoForm = () => {
    return defineForm({
        s_distrito: field("", yup.string().required("es requerido").min(3, 'Minimo 3 caracteres').max(100, "Máximo 100 caracteres")),
        provincia: field("", yup.string().required("es requerido")),
        departamento: field("", yup.string().required("es requerido")),
    });
};



const form = defineForm({
    distritos: formsField(generateDistritoForm, 1),
});


const onChangeDepartamento = async(codigo: string = '', index: number = 0) => {
    form.distritos.$forms[index].provincia.$value = ''
    await listarProvincia(codigo)
}


const onSubmit = () => {

    /*
    if (isValidForm(form)) {

        try {
            loading.value = true;
            const rpta =  saveDistrito(toObject(form.distritos ? form.distritos.$forms : {}));

            rpta.then((res) => {

                if (res?.status) {
                    router.push("/ubigeo");
                    notify({
                        title: "Exito",
                        text: res.message,
                    });
                    await listarUbigeo();
                }
            });
        } catch (error) {
            console.log(error)
        } finally {
            setTimeout(() => {
                loading.value = false;
            }, 1300);
        }

    }*/

};


</script>
