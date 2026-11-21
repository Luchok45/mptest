import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';

import VueTheMask from 'vue-the-mask';
import { mask } from 'vue-the-mask';
// @ts-ignore
import VueClipboard from 'vue3-clipboard';
import AuthLayout from '@/layouts/AuthLayout.vue';
import PrivilegesPlugin from '@/plugins/privileges-plugin.js';
import axios from 'axios';

const appName = import.meta.env.VITE_APP_NAME || 'Молодёжная политика';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

createInertiaApp({
    ssr: false,
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name.startsWith('oauth/') || name.startsWith('auth/'):
                return AuthLayout;
            default:
                return null;
        }
    },
    progress: {
        color: '#4B5563',
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrivilegesPlugin)
            .use(VueClipboard, {
                autoSetContainer: true,
                appendToBody: true,
            })
            .use(VueTheMask)
            .directive('mask', mask)
            .mount(el);
    },
});

// // This will set light / dark mode on page load...
// initializeTheme();
