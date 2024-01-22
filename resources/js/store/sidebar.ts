import { getOSInfo } from "@/utils/Os";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useSidebarStore = defineStore("SidebarStore", () => {
    const openSidebar = ref<boolean>(false);
    function togleSideBar() {
        const { isMobile } = getOSInfo();
        if (isMobile) {
            openSidebar.value = !openSidebar.value;
        } else {
            openSidebar.value = true;
        }
    }
    function hideSideBar() {
        openSidebar.value = false
    }
    function showSideBar() {
        openSidebar.value = true
    }
    return { openSidebar, togleSideBar , showSideBar, hideSideBar};
});
