import "../css/app.css";
import { createInertiaApp } from "@inertiajs/vue3";
import Default from "./layouts/Default.vue";

createInertiaApp({
    layout: () => Default,
});
