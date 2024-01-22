<template>
    <div
        :class="
            transparent ? 'bg-transparent' : '   '
        "
        class="w-full mb-1"
    >
        <LabelInput v-if="showLabel">{{ label }}:</LabelInput>
        <LabelError v-if="errorMessage && validateError"
            >* {{ errorMessage?.toString() }}</LabelError
        >
        {{ value }}
        <input
            :disabled="disabled"
            :type="type"
            :accept="accept"
            :name="name"
            :id="id"
            v-bind="$attrs"
            :value="value"
            :ref="myRefs"
            @input="handleChange"
            :class="
                transparent
                    ? 'bg-white  '
                    : (disabled
                          ? 'bg-[#EAEAE9] dark:bg-[#282828]'
                          : ' ') +
                      ' dark:text-gray-200  '
            "
            class="px-2 py-2 w-full flex md:px-4 border-0 focus:border-2 focus:border-primary-500 focus:ring-1 text-gray-600 focus:ring-primary-500 rounded-lg font-medium placeholder:font-normal"
        />
    </div>
</template>

<script lang="ts" setup>
import { LabelInput, LabelError } from "./Index";
const {
    type,
    value,
    label,
    accept,
    transparent,
    validateError,
    errorMessage,
    myRefs,
    name,
    id,
    showLabel,
    disabled,
} = withDefaults(
    defineProps<{
        type?: "text" | "number" | "date" | "file";
        value?: string | number | Date | File | null;
        label?: string;
        accept?: string;
        transparent?: boolean;
        validateError?: boolean;
        errorMessage?: string;
        myRefs?: any;
        name?: string;
        id?: string;
        showLabel?: boolean;
        disabled?: boolean;
    }>(),
    {
        type: "text",
        value: "",
        validateError: false,
        showLabel: true,
        disabled: false,
        errorMessage: "",
    }
);

const emit = defineEmits();

function handleChange($event) {
    emit("update:value", $event.target.value)
}
</script>
