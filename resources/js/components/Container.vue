<template>
 <div :class="`px-${distance}  w-full   overflow-auto  p-2  overflow-x-hidden overflow-y-scroll scrollbar  gap-4 mb-4 ` ">
    <slot></slot>
</div>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    name: "Container",
    props:{
        distance:
       {
        type: Number,
        default: 1
       }
    }
});
</script>

<style scoped>
.scrollbar::-webkit-scrollbar {
    width: 7px;
    height: 5px;

}

.scrollbar::-webkit-scrollbar-track {
    border-radius: 100vh;
    background:  transparent;
}

.scrollbar::-webkit-scrollbar-thumb {
    background: hsl(var(--p) / var(--tw-bg-opacity));
    border-radius: 100vh;
    /*border: 1px solid var(--color-primary);*/
}

.scrollbar::-webkit-scrollbar-thumb:hover {
    background: hsl(var(--p) / var(--tw-bg-opacity));
}
</style>


