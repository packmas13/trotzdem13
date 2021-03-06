require("./bootstrap");

// Import modules...
import { createApp, h } from "vue";
import {
    App as InertiaApp,
    plugin as InertiaPlugin,
} from "@inertiajs/inertia-vue3";

import InputLabel from "./input/InputLabel.vue";
import DraggablePlugin from "./plugins/draggable";

const el = document.getElementById("app");

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route }, components: { InputLabel } })
    .use(InertiaPlugin)
    .use(DraggablePlugin)
    .mount(el);
