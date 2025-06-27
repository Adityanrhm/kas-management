import "./bootstrap";

import Alpine from "alpinejs";
import "@fortawesome/fontawesome-free/js/all.js";
import persist from '@alpinejs/persist'

Alpine.plugin(persist)
window.Alpine = Alpine;

Alpine.start();
