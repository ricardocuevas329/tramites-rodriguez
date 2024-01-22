<template>
    <div class="relative mx-2">
        <SearchIcon />
        <input
            v-bind="$attrs"
            type="search"
            :value="modelValue"
            @input="updateInput"
            class="block w-full  pl-10 text-sm input   rounded-lg bg-base-300  focus:input-primary focus:border-none font-medium placeholder:font-normal  "
        />
    </div>
</template>

<script lang="ts">
import { defineComponent, type PropType } from 'vue';
import { PlusIcon } from "@heroicons/vue/20/solid";
import { SearchIcon } from "./Index";
export default defineComponent({
    name: "TextInputSearch",
    props: {
        modelValue: {
            default: '',
            type: String as PropType<string | number | File | null | undefined>,
        },
    },
    components: {
        PlusIcon,
        SearchIcon,
    },
    methods: {
        updateInput(event: any) {
            this.$emit("update:modelValue", event.target.value);
        },
    }
});
</script>
