<template>
  <div>

    <form @submit.prevent="onSubmit">
      <ScrollView>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


          <div v-for="(item, i) in form.provincias.$forms" :key="item.$key">


            <Center>
              <BtnRemove v-if="form.provincias.$forms.length > 1" @click="onRemove(i)">
                Eliminar
              </BtnRemove>
            </Center>


            <InputSelect :items="allDepartaments" label="Departamentos"
                         v-model="item.departamento.$value" :id="`name_${item.$key}`" :name="`name_${item.$key}`"
                         :error-message="item.departamento.$error?.message" label-data="s_departamento"
                         value-data="s_codigo"/>


            <TextInput autofocus label="Nombre" v-model="item.s_provincia.$value" :id="`name_${item.$key}`"
                       :name="`name_${item.$key}`" :error-message="item.s_provincia.$error?.message"/>
          </div>

        </div>
      </ScrollView>

      <div v-if="!id" class="flex ml-3 lg:ml-6">
        <BtnPush type="button" :disabled="!isValidForm(form)"
                 @click="isValidForm(form) && form.provincias.$append()">
          Agregar
        </BtnPush>
      </div>
      <Center>
        <BtnSave :text="id ? 'EDITAR PROVINCIA' : 'GRABAR PROVINCIA'" :disabled="loading" @click="onSubmit"/>
      </Center>
    </form>


  </div>
</template>

<script lang="ts" setup>
import {onMounted, ref, toRefs} from 'vue';

import {defineForm, field, formsField, isValidForm, toObject,} from "vue-yup-form";
import * as yup from "yup";
import {BtnPush, BtnRemove, BtnSave, Center, InputSelect, ScrollView, TextInput} from '../../../../components';
import {useRouter} from 'vue-router';
import {useDepartamentoStore} from '../../../../store/departamento';
import {useUbigeoStore} from '../../../../store/ubigeo';
import {useProvinciaStore} from '../../../../store/provincia';
import {notify} from '@kyvg/vue3-notification';


const {getAllDepartament} = useDepartamentoStore()
const {allDepartaments} = toRefs(useDepartamentoStore())

const {listarUbigeo} = useUbigeoStore()
const {saveProvincia, updateProvincia, findProvinciaById} = useProvinciaStore()
const router = useRouter();

const loading = ref(false);

const generateUbigeoForm = () => {
  return defineForm({
    s_provincia: field<string | null | undefined>("", yup.string().required("es requerido").min(3, 'Minimo 3 caracteres').max(100, "Máximo 100 caracteres")),
    departamento: field<string | null | undefined>("", yup.string()),

  });
};

const props = defineProps({
  id: {
    required: false,
    type: String,
    default: '',
  }
});

const {id} = props

const form = defineForm({
  provincias: formsField(generateUbigeoForm, 1),
});


const onSubmit = async () => {

  if (isValidForm(form)) {

    try {
      loading.value = true;
      /*@ts-ignore */
      let formData = toObject(form.provincias.$forms)
      const {status, message} = id ? await updateProvincia(id, formData) : await saveProvincia(formData);
      if (status) {
        await router.push("/ubigeo");
        notify({
          title: "Exito",
          text: message,
        });
        await listarUbigeo();
      }

    } catch (error) {
    } finally {
      setTimeout(() => {
        loading.value = false;
      }, 1300);
    }

  }

};


const onRemove = (i: number) => {
  form.provincias.$remove(i)
}


const getProvincia = async () => {
  const {status, Provincia} = await findProvinciaById(id.toString());
  if (status) {
    const {s_codigo, s_provincia} = Provincia
    form.provincias.$forms[0].s_codigo.$value = s_codigo
    form.provincias.$forms[0].s_provincia.$value = s_provincia ?? ''
  }

}


onMounted(() => {
  getAllDepartament()
  if (id) {
    getProvincia()
  }

})


</script>
