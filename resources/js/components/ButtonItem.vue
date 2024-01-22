<template>

        <div v-if="disabled"
            class="flex text-gray-400 dark:text-gray-700 flex-col mb-4 px-4 items-center pb-5 pt-5 mx-2 bg-gray-300 dark:bg-gray-800  border-1
             border-gray-500 rounded-lg shadow-md  dark:border-gray-700">
            <slot></slot>
            <h5 class="mb-1 truncate text-center w-full md:w-48 lg:w-full text-xs font-light  ">
                {{ text }}
            </h5>
        </div>
        <RouterLink v-if="!disabled" :to="to">
        <div  :title="text"
            class="flex  bg-base-100  flex-col mb-4 px-4 items-center pb-5 pt-5 mx-2   border-1 border-blue-100 rounded-lg shadow-md  dark:border-gray-700">
            <slot></slot>
            <h5 class="mb-1 truncate text-center w-full md:w-48 lg:w-full text-xs font-light   ">
                {{ text }}
            </h5>
        </div>
    </RouterLink>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "ButtonItem",
    props: {
        text: {
            default: 'Item',
            type: String
        },
        to: {
            default: '/',
            type: String
        },
        disabled:{
            required: false,
            type: Boolean,
            default: true
        }
    }
});
</script>

