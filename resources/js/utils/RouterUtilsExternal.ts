import LocalStorageService from "../services/LocalStorageService";

async function checkAuth(to, from, next) {
        const islogging = await LocalStorageService.getisLoggedIn();
        if (islogging) next();
        else next('/acceder');
}


async function checkAuthHome(to, from, next) {
    const isLogg = await LocalStorageService.getisLoggedIn();
    if (!isLogg) next();
    else next("/");
}

export { checkAuthHome, checkAuth };
