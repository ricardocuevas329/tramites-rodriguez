<template>
    <notifications>
        <template #body="props">
            <div class="py-5 px-5 space-y-5">
                <div class="relative mx-auto max-w-[400px] rounded-md p-4 text-sm shadow-lg" :class="props.item?.type == 'warn'
                            ? 'bg-error  '
                            : '  bg-success'
                        ">
                    <button @click="props.close" class="top-4 absolute right-4 ml-auto hover:text-slate-900 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path
                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                        </svg>
                    </button>
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <h4 class="pr-6 font-medium text-white">
                                {{ props.item.title }}
                            </h4>
                            <div v-html="props.item.text" class="mt-1 text-white"></div>
                            <div class="mt-2 flex space-x-4">
                                <button @click="props.close"
                                        class="inline-block font-medium leading-loose text-white hover:text-slate-900">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </notifications>
</template>
<script setup lang="ts">
</script>
