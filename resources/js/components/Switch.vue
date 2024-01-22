<template>
  <div class="form-control w-52 flex">
    <label class="cursor-pointer label">
      <span class="label-text">{{ text }}</span>
      <input type="checkbox" @input="updateInput" v-bind="$attrs" class="toggle toggle-primary" v-model="val"  />
    </label>
  </div>
</template>
<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: "Switch",
  props:{
    text:{
      type: String,
      required: true
    },
    modelValue: {
      type:  Boolean,
      default: "",
    },
  },
  data(){
    return {
      val: false
    }
  },
  methods:{
    updateInput(event: any) {
      this.$emit("update:modelValue", this.val);
    },
  }
});
</script>
