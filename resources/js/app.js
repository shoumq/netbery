import './bootstrap';
import '../sass/app.css';
import '../js/rem.js';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Vuelidate from '@vuelidate/core';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    // title: (title) => `${title} - ${appName}`,
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            // .mixin({methods: {route: window}})
            .use(ZiggyVue, Ziggy)
            .use(Vuelidate)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
