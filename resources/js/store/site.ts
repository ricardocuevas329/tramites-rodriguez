import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Site } from "../models/Site";
import type { ResponseByEntity } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

export const useSiteConfigStore = defineStore("siteConfig", () => {
    const site = ref<Site>();
    async function ListSiteConfig() {
        const { data: { data, status }  }: ResponseByEntity<Site> = await axios.get(API_URL+"/api/site")
        if(status){
           site.value = data;
        }
    }

    return { site, ListSiteConfig };
});
