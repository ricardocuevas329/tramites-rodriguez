<template>
    <div>
        <aside
            v-if="openSidebar"
            class="fixed z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75"
            aria-label="Sidebar"
        >
            <span
                @click="togleSideBar"
                class="lg:hidden top-2 fixed z-20 mr-2 text-gray-600 hover:text-primary cursor-pointer p-2 hover:bg-primary focus:bg-primary  focus:ring-2 focus:ring-primary rounded"
            >
                <svg
                    class="w-6 h-6 hover:text-white"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
            </span>
            <div
                class="relative flex-1 bg-base-100  flex flex-col min-h-0  dark:text-gray-400 pt-0"
            >
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div
                        class="flex-1 px-3  divide-y space-y-1"
                    >
                        <Menu />
                    </div>
                </div>
            </div>
        </aside>
    </div>
</template>

<script lang="ts" setup>
import { toRefs } from "vue";
import { useSidebarStore } from "../store/sidebar";
import Menu from "./Menu.vue";
const { openSidebar } = toRefs(useSidebarStore());
const { togleSideBar } = useSidebarStore();
// <div v-if="openSidebar && isMobile" @click="togleSideBar" class="cursor-pointer bg-gray-700 opacity-50  fixed inset-0 z-10"  ></div>
</script>
