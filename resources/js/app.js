import "./bootstrap";

import Alpine from "alpinejs";
import "@fortawesome/fontawesome-free/js/all.js";

window.Alpine = Alpine;

Alpine.start();

// Animastion preloader
window.addEventListener("load", function () {
    const preloader = document.getElementById("preloader");
    if (preloader) {
        preloader.classList.add("hide"); // 🔁 trigger fade out
        setTimeout(() => {
            preloader.remove();
        }, 800); // ⏱ waktu tunggu > dari 0.6s biar animasi selesai
    }
});
