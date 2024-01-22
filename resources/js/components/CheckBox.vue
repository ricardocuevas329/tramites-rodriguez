<template>
    <div class="flex">
        <input
            type="checkbox"
            :id="id"
            :name="name"
            class=" checkbox checkbox-primary checkbox-xs bg-base-100"
            v-model="model"
            :value="value"
            v-bind="$attrs"
        />
        <label
            :for="id"
            class=" mx-2  select-none cursor-pointer text-xs"
            @click="toggleChecked"
        >
            <slot></slot>
        </label>
    </div>
</template>

<script lang="ts">
export default {
    props: {
        modelValue: { type: [Array, Boolean], default: false },
        value: { type: [Boolean, Object], default: false },
        id: {
            type: String,
            required: false,
        },
        name: {
            type: String,
            default: null,
            required: false,
        },
    },
    computed: {
        model: {
            get() {
                return this.modelValue;
            },
            set(value: boolean) {
                this.$emit("update:modelValue", value);
            },
        },
    },
    methods: {
        toggleChecked() {
            this.$emit("input", !this.modelValue);
        },
    },
};
</script>
