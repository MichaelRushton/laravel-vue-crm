import "../css/app.css";
import { createInertiaApp } from "@inertiajs/vue3";
import Default from "./Layouts/Default.vue";

createInertiaApp({
    layout: () => Default,
});
