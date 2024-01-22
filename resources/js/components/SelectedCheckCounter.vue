<template>
    <TransitionRoot
        appear
        :show="isShowing"
        as="template"
        enter="transform transition duration-[400ms]"
        enter-from="opacity-0 rotate-[-120deg] scale-50"
        enter-to="opacity-100 rotate-0 scale-100"
        leave="transform duration-200 transition ease-in-out"
        leave-from="opacity-100 rotate-0 scale-100 "
        leave-to="opacity-0 scale-95 "
    >
        <p
            class="t-0 absolute right-6 flex h-2 w-2 items-center justify-center rounded-full p-3 text-xs text-white bg-gradient-to-br from-purple-600 to-primary-500 dark:from-primary-600 dark:to-primary-700 hover:bg-gradient-to-bl"
        >
            <slot></slot>
        </p>
    </TransitionRoot>
</template>
<script lang="ts" setup>
import { TransitionRoot } from "@headlessui/vue";
import { ref } from "vue";
const isShowing = ref(true);
</script>
