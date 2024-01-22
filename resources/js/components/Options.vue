<template>
    <div class="relative z-[10]">
        <Menu as="div" class="dropdown-end dropdown">
            <MenuButton tabindex="0" class="btn-ghost btn gap-1 normal-case">
                <span class="  md:inline" v-text="text"></span>
                <svg
                    width="12px"
                    height="12px"
                    class="ml-1   h-3 w-3 fill-current opacity-60 sm:inline-block"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 2048 2048"
                >
                    <path
                        d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"
                    />
                </svg>
            </MenuButton>

            <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
            >
                <MenuItems
                    class="absolute left-0 mt-2 w-56 origin-top-right   rounded-md bg-base-200 shadow-lg ring-opacity-5 focus:outline-none"
                >
                    <div class="lg:mx-1 lg:px-1 mx-2 px-3 py-1">
                        <slot />
                    </div>
                </MenuItems>
            </transition>
        </Menu>
    </div>
</template>
<script lang="ts">
import { MenuItems, Menu, MenuButton } from "@headlessui/vue";
import { defineComponent } from "vue";
export default defineComponent({
    name: "Options",
    props: {
        text: {
            type: String,
            default: "Mas Opciones",
        },
        defaultStyle: {
            type: Boolean,
            default: false,
            required: false,
        },
    },
    components: { MenuItems, Menu, MenuButton },
});
</script>
