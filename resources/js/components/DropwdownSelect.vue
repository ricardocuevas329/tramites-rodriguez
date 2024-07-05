<template>
    <div class="px-1 lg:px-2" :class="compact ? 'mb-2' : 'my-5'">
        <LabelInput v-if="title"
        >{{ title }}
          <LabelError v-if="errorMessage && validateError">* {{ errorMessage?.toString() }}</LabelError>
           </LabelInput
        >
        <div class="flex cursor-default sm:text-sm">
            <div class="flex w-full" :title="placeholder">
                <AutoComplete
                    :placeholder="placeholder"
                    :inputId="id"
                    v-model="query"
                    @input="updateValue"
                    optionLabel="nombre_compuesto"
                    :suggestions="data"
                    @item-select="itemSelect"
                    emptySearchMessage="Sin concidencias.."
                    class="w-full"
                >
                    <template #option="slotProps">
                        <div
                            class="flex align-options-center"
                            style="height: 10px"
                            @click="onSelecteValue(slotProps.option)"
                        >

                            <div >
                                <p v-if="label">{{ slotProps.option[label] }}
                                    <span v-if="label2"> - </span>
                                    <span>{{ slotProps.option[label2] }}</span>
                                    <span v-if="label3"> - </span>
                                    <span>{{ slotProps.option[label3] }}</span>
                                </p>
                            </div>
                            <div v-if="propObjet" class="mx-1">
                                <div>{{ getNestedProperty(slotProps.option, propObjet) }}</div>
                            </div>
                            <div v-if="propObjet2" class="">
                                <div> - {{ getNestedProperty(slotProps.option, propObjet2) }}</div>
                            </div>
                        </div>
                    </template>
                </AutoComplete>
                <div class="flex mt-2 gap-1">
                    <button
                        title="limpiar"
                        v-if="modelValue?.toString().trim() != ''"
                        class="btn btn-icon btn-xs btn-circle"
                        @click="clearInput"
                    >
                        <i class="pi pi-times text-error"></i>
                    </button>

                </div>
            </div>
        </div>

    </div>
</template>
<script lang="ts" setup>
import {type PropType, ref, toRefs} from "vue";
import {LabelError, LabelInput} from "@/components/Index";
import { get } from 'lodash';
import AutoComplete, { type AutoCompleteItemSelectEvent } from 'primevue/autocomplete';
import { useGenerateKeyRandom, useOpenModal } from "@/hooks/useUtils";

const idModalEdit = useGenerateKeyRandom()
const query = ref<string>("");
const emit = defineEmits(["update:modelValue", "onSelecteValue", "onClear"]);
const isEdit = ref<boolean>(false);
const titleEdit = ref<string>("");
const cod_selected = ref<string>("");
const isEditClient = ref<boolean>(false);
const isEditCompany = ref<boolean>(false);

const props = defineProps({
    propObjet2: {
        type: String,
        required: false,
    },
    propObjet: {
        type: String,
        required: false,
    },
    compact: {
        dafault: false,
        type: Boolean,
        required: false
    },
    modelValue: {
        default: null || "",
        type: String as PropType<string | number | null | undefined>,
    },
    data: {
        default: {},
        require: false,
        type: Object as PropType<any>,
    }, title: {
        default: "",
        require: false,
        type: String,
    },
    label: {
        default: "label",
        require: true,
        type: String,
    },
    placeholder: {
        default: "Filtrar...",
        require: false,
        type: String,
    },
    label2: {
        default: "",
        require: false,
        type: String,
    },
    label3: {
        default: "",
        require: false,
        type: String,
    },
    id: {
        require: false,
        type: String,
    },
    showIconArrow: {
        default: true,
        type: Boolean,
    },
    errorMessage: {
        type: String,
        default: "",
    },
    validateError: {
        type: Boolean,
        default: true,
    },
});

const {data, label, label2, label3, modelValue, id} = toRefs(props);

const updateValue = (event) => {
    emit("update:modelValue", event.target.value);
};

const onSelecteValue = (select) => {
    emit("onSelecteValue", select);
    query.value = ""

};

const clearInput = () => {
    emit("onClear", true)
    emit("update:modelValue", "");
    query.value = ""
    isEdit.value = false
    isEditClient.value = false
    isEditCompany.value = false
}

const getNestedProperty = (obj, propPath) => {
    return get(obj, propPath, '');
}

const itemSelect = (payload:AutoCompleteItemSelectEvent) => {
    onSelecteValue(payload.value)
    if (payload.value?.s_codigo) {
        cod_selected.value = payload.value?.s_codigo
        if (/CL/.test(payload.value?.s_codigo)){
            isEdit.value = true
            titleEdit.value = "Editar Cliente"
            isEditClient.value = true
            isEditCompany.value = false
        }

        if (/EP/.test(payload.value?.s_codigo)) {
            isEdit.value = true
            titleEdit.value = "Editar Empresa"
            isEditClient.value = false
            isEditCompany.value = true
        }

    }else{
        isEdit.value = false
    }

}

const onOpenEdit = () => {
    useOpenModal(idModalEdit)
}



/*watch(
  () => query.value,
  (newVal) => {
    if (typeof newVal === "object") {
        onSelecteValue(newVal);
    }
}
)*/
</script>

<style>
.custom-placeholder-color::placeholder {
    color: oklch(var(--b));
}
</style>
