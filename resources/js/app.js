import "./bootstrap";

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import "@fortawesome/fontawesome-free/js/all.js";
import Swal from "sweetalert2";

Alpine.plugin(persist);
window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();
