<template>
    <p class="truncate font-bold  "><slot></slot></p>
</template>
<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "TitleTable",
});
</script>
