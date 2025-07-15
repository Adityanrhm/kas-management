import "./bootstrap";
import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import "@fortawesome/fontawesome-free/js/all.js";
import Swal from "sweetalert2";
import AOS from 'aos';
import 'aos/dist/aos.css';

Alpine.plugin(persist);
window.Alpine = Alpine;
window.Swal = Swal;

AOS.init();
Alpine.start();
