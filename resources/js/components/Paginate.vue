<template>
    <div class="flex w-full mt-5 space-x-2 justify-end">
        <button v-if="pagination.current_page != 1" @click.prevent="change(pagination.current_page - 1)"
            class="inline-flex items-center h-8 w-8 justify-center text-gray-600 rounded-md shadow border bg-base-100 border-base-200 dark:border-gray-800 leading-none">
            <svg class="w-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button v-for="page in pages" :key="page" @click.prevent="change(page)" :disabled="(pagination.current_page == page)"
            :class="page != pagination.current_page ? 'dark:bg-card-dark bg-base-100 dark:text-white text-gray-600 ' : 'dark:bg-gray-600 bg-primary  text-white'"
            class="inline-flex items-center h-8 w-8 justify-center  rounded-md shadow border border-base-200 dark:border-gray-800 leading-none">
            {{ page }} </button>
 
        <button v-if=" pagination.last_page !=  pagination.current_page"  @click.prevent="change(pagination.current_page + 1)"
            class="inline-flex items-center h-8 w-8 justify-center bg-base-100 text-gray-600 rounded-md shadow border border-base-200 dark:border-gray-800 leading-none">
            <svg class="w-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>
</template>
<script lang="ts">
import { defineComponent, type PropType } from 'vue';
import type { Pagination } from '../models/Pagination';
export default defineComponent({
    name: "Paginate",
    props: {
        pagination: {
            type: Object as PropType<Pagination>,  
            default:{ 
                current_page:0,
                from:0,
                last_page:0,
                per_page:0,
                to:0,
                total:0
            }
            //required: true,
        },
        offset: {
            type: Number,
            default: 2,
        },
    },
    computed: {
        pages() {
            var from = 0
            let pages = new Array()
            if (!this.pagination.to) {
                return null;
            }
             from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + this.offset * 2;
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
             
            for (let page = from; page <= to; page++) {
                (pages as any[]).push(page)
            }
            return pages;
        },
    },
    methods: {
        change: function (page) {
            this.pagination.current_page = page;
            this.$emit("paginate");
        },
    },
});
</script>
 