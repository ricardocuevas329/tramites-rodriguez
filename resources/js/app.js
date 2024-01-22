import './bootstrap';
import {createApp} from 'vue'
import {createPinia} from 'pinia'
import App from './App.vue'
import {router} from './router/index'
import Notifications from '@kyvg/vue3-notification'
import {Vue3ProgressPlugin} from '@marcoschulte/vue3-progress';
import PrimeVue from 'primevue/config';
import {MyDesignSystem} from "./utils/DesignSystemPrimeConfig";
import 'primeicons/primeicons.css'
import Tooltip from 'primevue/tooltip';
import 'virtual:windi-base.css'
import 'virtual:windi-components.css'
import 'virtual:windi-utilities.css'
import '../css/app.css'


const pinia = createPinia()
const app = createApp(App)
if (import.meta.hot) {
    import.meta.hot.accept();
}


app.directive('click-outside', {
    beforeMount(el, binding) {
        const handleClickOutside = (event) => {
            if (!el.contains(event.target) && el !== event.target) {
                binding.value();
            }
        };

        document.addEventListener('click', handleClickOutside);

        el.__clickOutsideHandler__ = handleClickOutside;
    },
    unmounted(el) {
        document.removeEventListener('click', el.__clickOutsideHandler__);
        delete el.__clickOutsideHandler__;
    },
});
app.use(router)
app.use(Vue3ProgressPlugin)
app.use(pinia)
app.use(Notifications)
app.use(PrimeVue, { ripple: true, unstyled: true, pt: MyDesignSystem });
app.directive('tooltip', Tooltip);
app.mount("#app")



