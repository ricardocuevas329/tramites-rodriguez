<template>

    <div class=" mt-5   justify-center">
        <div class="flex flex-col  shadow-md  rounded-md items-center">
            <div v-if="tipo == 1" class="flex w-full items-center p-4">
                <div data-placeholder
                    class="mr-2 h-10 w-10  rounded-full overflow-hidden relative bg-base-300 ">
                </div>
                <div class="flex flex-col justify-between items-center">
                    <div data-placeholder class="mb-2 h-5 w-80 overflow-hidden relative bg-base-300 ">
                    </div>

                </div>
            </div>
            <div v-if="(tipo == 2)" data-placeholder
                class="h-52 w-full overflow-hidden relative bg-base-300 "></div>
            <div v-if="(tipo == 2)" class="flex flex-col p-4">
                <div class="flex">
                    <div data-placeholder
                        class=" flex h-5 w-5 overflow-hidden relative bg-base-300  mr-1"></div>
                    <div data-placeholder class="flex h-5 w-48 overflow-hidden relative bg-base-300 ">
                    </div>
                </div>
                <div class="flex mt-1">
                    <div data-placeholder
                        class="flex h-5 w-5 overflow-hidden relative bg-base-300  mr-1"></div>
                    <div data-placeholder class="flex h-5 w-48 overflow-hidden relative bg-base-300 ">
                    </div>
                </div>
            </div>
            <div v-if="(tipo == 3)" class="w-full h-px  overflow-hidden relative bg-base-300  m-4">
            </div>
            <div v-if="(tipo == 3)" class="flex justify-between items-center p-4 w-full">
                <div data-placeholder class="mr-2 h-10 w-16  overflow-hidden relative bg-base-300 ">
                </div>
                <div data-placeholder class="mb-2 h-5 w-20 overflow-hidden relative bg-base-300 ">
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
export default {
    props: {
        tipo: {
            type: Number,
            default: 1
        },
    }
}
</script>
<style lang="scss">
[data-placeholder]::after {
    content: " ";
    box-shadow: 0 0 50px 9px rgba(254, 254, 254);
    position: absolute;
    top: 0;
    left: -100%;
    height: 100%;
    animation: load 1s infinite;
}

@keyframes load {
    0% {
        left: -100%
    }

    100% {
        left: 150%
    }
}
</style>
