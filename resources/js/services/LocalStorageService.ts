const LocalStorageService = (function () {

    async function _getisLoggedIn() {
        let isLoggedIn = await localStorage.getItem('isLoggedIn');
        return !isLoggedIn ? false : true
    }


    function _setToken(token: string) {
        localStorage.setItem("access_token", token.toString());
        localStorage.setItem("isLoggedIn", 'true');
    }

    function _getAccessToken() {
        return localStorage.getItem("access_token");
    }

    function _clearToken() {
        localStorage.removeItem("access_token");
        localStorage.removeItem("isLoggedIn");
    }

    function _setChangePassword() {
        localStorage.setItem("change_password", 'true');
    }

    function _clearChangePassword() {
        localStorage.removeItem("change_password");
    }

    async function _getChangePassword() {
        let state = await localStorage.getItem("change_password");
        return !state ? false : true
    }

    function _setKey(key: string, value: string) {
        localStorage.setItem(key.toString(), value.toString());
    }
    function _getKey(key: string) {
        return localStorage.getItem(key.toString());
    }
    return {
        setToken: _setToken,
        getAccessToken: _getAccessToken,
        clearToken: _clearToken,
        getisLoggedIn: _getisLoggedIn,
        setChangePassword: _setChangePassword,
        clearChangePassword: _clearChangePassword,
        getChangePassword: _getChangePassword,
        setKeyServiceStorage: _setKey,
        getKeyServiceStorage: _getKey
    };
})();
export default LocalStorageService;