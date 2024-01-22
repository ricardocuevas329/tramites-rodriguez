<template>
    <div class="form-control">
    <label class="label cursor-pointer">
        <span class="label-text mx-2">{{ label }}</span> 
        <input type="radio"
            v-bind="$attrs"
            :value="value"
            :checked="isChecked"
            @click="handleChange"  
            class="radio radio-primary bg-base-200" />
    </label>
    </div>
    
</template>

<script setup lang="ts">
import { computed } from "vue";
const { label, value, modelValue } = defineProps([
    "label",
    "value",
    "modelValue",
]);

const emit = defineEmits();

const isChecked = computed(() => modelValue === value);

function handleChange() {
    emit("update:modelValue", value);
}
</script>
