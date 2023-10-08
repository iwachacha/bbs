import './bootstrap.js';
import '../css/app.css';

import { vuetify } from './vuetify.js';

import './validationMessage.js';

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import { options } from './toastr.js';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || '文教大学越谷キャンパス情報掲示板';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(vuetify)
            .use(Toast, options)
            .mount(el);
    },
    progress: {
        color: '#00BFA5',
        showSpinner: true,
    },
});
