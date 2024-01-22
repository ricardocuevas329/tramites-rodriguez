<template>
    <div class="text-center tabs tabs-boxed  tab-xs">
        <div class="">
            <a
                class="bg-base-300 mx-1 my-1 tab  "
                v-for="(tab, index) in tabs"
                :key="index + 1"
                @click="selectedTab = index + 1"
                :class="index + 1 === selectedTab && 'tab-active'"
            >
                <component
                    v-if="icons?.length"
                    v-for="(icon, i) in icons"
                    :key="i"
                    :is="i + 1 == index + 1 && icon"
                    class="w-5"
                />
                <span class="mx-1 text-xs">{{
                    getTitle(tab?.toString())
                }}</span>
            </a>
        </div>
    </div>
    <div class="mt-1">
        <div
            v-for="(content, index) in tabs"
            :key="index + 1"
            v-show="selectedTab === index + 1"
        >
            <slot :name="content"></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

const props = defineProps({
    tabs: { type: Array<string>, required: true },
    icons: { type: Array, required: false },
});

const selectedTab = ref(1);

function getTitle(textNotSpace: any) {
    const keys = textNotSpace.split(/(?=[A-Z1-9])/);
    const titleSpacing = keys.map(
        (str: string) =>
            str.charAt(0).toUpperCase() + str.slice(1).toLowerCase()
    );
    return titleSpacing.join(" ");
}
defineExpose({ selectedTab });
</script>
<style>
.tab{
    height: 1.3rem!important;
}
</style>