<template>

  <Combobox :value="modelValue" @input="updateValue">
    <div class="relative px-4 lg:px-2"  :class="compact?'mb-2':'my-5'">
      <span v-if="errorMessage && validateError" class=" font-sm font-semibold  text-red-600 text-xs   mx-2">* {{ errorMessage?.toString() }}</span>
      <div
          class="flex relative w-full cursor-default focus:border-primary focus:ring-1 focus:ring-primary text-left sm:text-sm"
      >
        <div v-if="$slots.startIcon" class="mx-1 mt-2">
          <slot name="startIcon"></slot>
        </div>
        <ComboboxInput
            :id="id"
            :placeholder="placeholder"
            class="bg-base-200 w-full input   md:px-4 md:py-3 rounded-lg py-3 pl-3 pr-10 text-sm focus:input-primary focus:border-none font-medium placeholder:font-normal"
            :displayValue="
                        (item) =>
                            modelValue?.toString()
                                ? `${item?.[label] }${label2 != '' ? '-' : '' }${ label2 ? item?.[label2] ?? '' : ''}${label3 != '' ? '-' : ''}${label3 ? item?.[label3] ?? '' : ''}`
                                : ''
                    "
            @change="query = $event.target.value"
            autocomplete="off"
        />

        <ComboboxButton
            class="absolute  inset-y-0 right-0 flex items-center pr-2"
        >
          <svg
              class="w-5 h-5 "
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
          >
            <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
            ></path>
          </svg>
          <div title="limpiar"
               v-if="modelValue?.toString().trim() != ''"
               class="cursor-pointer flex full absolute top-2 right-8"
               @click="clearInput"
          >
            <CloseCircle class="w-7 text-primary rounded-lg bg-base-200"/>
          </div>
          <ChevronUpDownIcon v-if="showIconArrow"
                             class="h-5 w-5 text-gray-400"
                             aria-hidden="true"
          />
        </ComboboxButton>
      </div>
      <TransitionRoot
          leave="transition ease-in duration-100"
          leaveFrom="opacity-100"
          leaveTo="opacity-0"
          @after-leave="query = ''"
      >
        <ComboboxOptions
            class="absolute z-[100] mt-1 max-h-60 w-full overflow-auto rounded-md bg-base-100 py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <div
              v-if="data.length === 0 && query !== ''"
              class="relative cursor-default select-none py-2 px-4"
          >
            Sin resultados.
          </div>

          <ComboboxOption
              v-for="item in data"
              as="template"
              :key="item.id"
              :value="item"
              v-slot="{ selected, active }"
              @click="onSelecteValue(item)"
          >
            <li
                class="relative cursor-pointer select-none py-2 pl-10 pr-4"
                :class="{
                                'bg-primary text-white': active,
                                '': !active,
                            }"
            >
                            <span
                                class="block truncate text-xs"
                                :class="{
                                    'font-medium': selected,
                                    'font-normal': !selected,
                                }"
                            >
                              {{
                                `${item[label]} ${label2 != '' ? '-' : ''} ${label2 ? item[label2] ?? '' : ''} ${label3 != '' ? '-' : ''} ${label3 ? item[label3] ?? '' : ''} `
                              }}
                            </span>
              <span
                  v-if="selected"
                  class="absolute inset-y-0 left-0 flex items-center pl-3"
                  :class="{
                                    'text-white': active,
                                    'text-primary': !active,
                                }"
              >
                                <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                            </span>
            </li>
          </ComboboxOption>
        </ComboboxOptions>
      </TransitionRoot>
    </div>
  </Combobox>
</template>
<script lang="ts" setup>
import {
  Combobox,
  ComboboxButton,
  ComboboxInput,
  ComboboxOption,
  ComboboxOptions,
  TransitionRoot,
} from "@headlessui/vue";
import {CheckIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid";
import {type PropType, ref, toRefs} from "vue";
import CloseCircle from "@vicons/ionicons5/CloseCircle";
import {LabelError} from "@/components/Index";

const query = ref<string>("");
const emit = defineEmits(["update:modelValue", "onSelecteValue", "onClear"]);

const props = defineProps({
  compact: {
    dafault: false,
    type: Boolean,
    required: false
  },
  modelValue: {
    default: null || "",
    type: String as PropType<string | number | null | undefined>,
  },
  data: {
    default: {},
    require: false,
    type: Object as PropType<any>,
  },
  label: {
    default: "label",
    require: true,
    type: String,
  },
  placeholder: {
    default: "Filtrar...",
    require: false,
    type: String,
  },
  label2: {
    default: "",
    require: false,
    type: String,
  },
  label3: {
    default: "",
    require: false,
    type: String,
  },
  id: {
    default: "",
    require: false,
    type: String,
  },
  showIconArrow: {
    default: true,
    type: Boolean,
  },
  errorMessage: {
    type: String,
    default: "",
  },
  validateError: {
    type: Boolean,
    default: true,
  },
});

const {data, label, label2, label3} = toRefs(props);

const updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};

const onSelecteValue = (select) => {
  emit("onSelecteValue", select);
};

const clearInput = () => {
  emit("onClear", true)
  emit("update:modelValue", "");
}
</script>
