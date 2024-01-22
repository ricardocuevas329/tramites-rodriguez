import {RoutesNamesHome} from "@/router";
import LocalStorageService from "../services/LocalStorageService";
import {ref} from "vue"

function usePropsRoute(props: object) {
    return history.pushState(props, '', '');
}

function useGetPropsRoute() {
    const propsData = ref(null);

    function getPropsRoute() {
        setTimeout(() => {
            propsData.value = window.history.state;
            window.history.back();
        }, 500);
    }
    getPropsRoute();

    return {
        params_route: propsData,
    };
}



async function checkAuth(to, from, next) {
    const changePass = await LocalStorageService.getChangePassword();
    if (!changePass) {
        const islogging = await LocalStorageService.getisLoggedIn();
        if (islogging) next();
        else next(RoutesNamesHome.login.path);
        //else window.location.href = RoutesNamesHome.login.path
    } else {
        next(RoutesNamesHome.changePassword.path);
    }
}

function generateSlug(str: string) {
    return str.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}

async function checkAuthHome(to, from, next) {
    const isLogg = await LocalStorageService.getisLoggedIn();
    if (!isLogg) next();
    else next("/");
}

export {generateSlug, checkAuthHome, checkAuth, usePropsRoute, useGetPropsRoute};
