<template>
  <div>
    <RouterLink v-if="path" :to="path">
      <button class="btn btn-outline">
        <DeleteEmptyOutline :size="25" fill="currentColor" />
        <span class="text-white">{{ text }}</span>
      </button>
    </RouterLink>

    <div v-if="!path" :title="text">
      <button
        :disabled="disabled"
        @click.prevent="$emit('click', $event)"
        class="btn btn-sm btn-outline"
        :class="icon && 'btn-circle'"
      >
        <DeleteEmptyOutline :size="25" fill="currentColor" />
        <span v-if="!icon" class="text-white">{{ text }}</span>
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import DeleteEmptyOutline from "vue-material-design-icons/DeleteEmptyOutline.vue";

export default defineComponent({
  components: {
    DeleteEmptyOutline,
  },
  name: "BtnClean",
  emits: ["click"],
  props: {
    text: {
      default: "Limpiar Campos",
      type: String,
      required: false,
    },
    path: {
      default: "",
      type: String,
    },
    disabled: {
      required: false,
      default: false,
      type: Boolean,
    },
    icon: {
      required: false,
      default: false,
      type: Boolean,
    },
  },
});
</script>
