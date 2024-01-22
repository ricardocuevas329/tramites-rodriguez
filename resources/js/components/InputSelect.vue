<template>
    <div class="w-full lg:px-2 px-1 mb-3 relative">
        <LabelInput v-if="showLabel">{{ label }}:</LabelInput>
        <div v-if="!showLabel" class="mt-4"></div>
        <LabelError v-if="errorMessage && validateError"
            >* {{ errorMessage }}</LabelError
        >
        <select
            :name="name"
            :id="id"
            :value="modelValue"
            @input="updateInput"
            v-bind="$attrs"
            class="px-2 py-2.5 select  md:px-4 input bg-base-200 text-sm  appearance-none w-full flex focus:input-primary focus:border-none font-medium placeholder:font-normal  rounded-lg  "
        >
            <option
                v-for="(item, i) in items"
                :key="i"
                :value="item[valueData]"
            >
                {{ item[labelData] }}
            </option>
        </select>
    </div>
</template>

<script lang="ts">
import { defineComponent, type PropType } from "vue";
import { LabelInput, LabelError } from "./Index";

export default defineComponent({
    name: "InputSelect",
    components: { LabelInput, LabelError },
    props: {
        label: String,
        icon: String,
        errorMessage: String,
        name: {
            type: String,
            default: "",
        },
        id: {
            type: String,
            default: null,
            required: false,
        },
        /**@ts-ignore */
        modelValue: {
            default: "",
            type: [Number, String, null],
        },
        items: {
            default: [],
            type: Array as PropType<any[]>,
        },
        labelData: {
            required: false,
            type: String,
            default: "label",
        },
        valueData: {
            required: false,
            type: [Number, String],
            default: "id",
        },
        validateError: {
            type: Boolean,
            default: true,
        },
        showLabel: {
            type: Boolean,
            default: true,
        }
    },
    methods: {
        updateInput(event: any) {
             /**@ts-ignore */
            this.$emit("update:modelValue", event.target.value);
            /**@ts-ignore */
            const elementoEncontrado = this.items.find(elemento => elemento[this.valueData] == event.target.value);
            if (elementoEncontrado !== undefined) {
                /**@ts-ignore */
                this.$emit("onGetLabel", elementoEncontrado[this.labelData] );
            }


        },
    },
});
</script>
