import "./bootstrap";

import Alpine from "alpinejs";
import "@fortawesome/fontawesome-free/js/all.js";
import Swal from "sweetalert2";
import persist from "@alpinejs/persist";

Alpine.plugin(persist);
window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();
