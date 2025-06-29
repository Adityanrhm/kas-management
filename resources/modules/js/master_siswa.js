// Function untuk modal siswa (jika belum ada)
function siswaModal() {
    return {
        isEdit: false,
        formAction: window.routes["master.store.siswa"],
        formData: {
            nis: window.defaultNis || "",
            email: "",
            name: "",
            class: "",
        },
        previewImage: "",
        fileName: "",

        init() {
            // console.log("Modal component initialized");
            // Set default NIS jika ada
            if (window.defaultNis) {
                this.formData.nis = window.defaultNis;
            }
        },

        resetForm() {
            this.isEdit = false;
            this.formAction = window.routes["master.store.siswa"];
            this.formData = {
                nis: window.defaultNis || "",
                email: "",
                name: "",
                class: "",
            };
            this.previewImage = "";
            this.fileName = "";

            // Reset file input
            const fileInput = document.getElementById("photo");
            if (fileInput) {
                fileInput.value = "";
            }
        },

        editForm(data) {
            this.isEdit = true;
            this.formAction = `/master/siswa/${data.id}`;
            this.formData = {
                nis: data.nis || "",
                email: data.email || "",
                name: data.name || "",
                class: data.class || "",
            };

            // Set preview image jika ada avatar
            if (data.avatar) {
                this.previewImage = `${window.storageUrl}/${data.avatar}`;
            }
        },

        previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;

                // Create preview URL
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        removePhoto() {
            this.fileName = "";
            this.previewImage = "";

            // Reset file input
            const fileInput = document.getElementById("photo");
            if (fileInput) {
                fileInput.value = "";
            }
        },
    };
}

// Function untuk search data siswa
function searchData() {
    return {
        query: "",
        results: window.initialData || [], // Initial data dari window variable
        originalData: window.initialData || [], // Backup original data
        loading: false,
        searchTimeout: null,

        init() {
            // console.log("Search component initialized");
            // console.log("Initial data count:", this.results.length);
        },

        performSearch() {
            // Clear previous timeout
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            // If query is empty, show original data
            if (this.query.trim() === "") {
                this.results = this.originalData;
                return;
            }

            // Set loading state
            this.loading = true;

            // Debounce search
            this.searchTimeout = setTimeout(() => {
                this.fetchData();
            }, 300);
        },

        async fetchData() {
            try {
                const response = await fetch(
                    `/master/siswa?q=${encodeURIComponent(this.query)}`,
                    {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            Accept: "application/json",
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN":
                                document
                                    .querySelector('meta[name="csrf-token"]')
                                    ?.getAttribute("content") || "",
                        },
                    }
                );

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                // console.log("Search results:", data);
                this.results = data;
            } catch (error) {
                console.error("Search error:", error);
                // Show error to user
                this.results = [];
            } finally {
                this.loading = false;
            }
        },
    };
}

// Export functions untuk penggunaan global
window.searchData = searchData;
window.siswaModal = siswaModal;

// Perbaikan JavaScript Search dengan Error Handling
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-siswa");
    const tableBody = document.getElementById("tbody-siswa");
    // console.log(searchInput);

    searchInput.addEventListener("input", function () {
        const query = searchInput.value;

        fetch(`/master/siswa/search?q=${encodeURIComponent(query)}`)
            .then((res) => res.json())
            .then((data) => {
                let html = "";
                // console.log(data);
                if (data.data.length === 0) {
                    html = `<tr><td colspan="7" class="p-4 text-center text-white/50 italic">No data found.</td></tr>`;
                } else {
                    data.data.forEach((user) => {
                        // Template HTML di JavaScript (masih duplikasi, tapi di client-side)
                        html += `
                        <tr class="border-b border-white/20 hover:bg-white/5 transition duration-300">
                            <td class="text-left py-3 px-3">
                                <img src="${window.storageUrl}/${
                            user.avatar || "default.png"
                        }" class="h-10 w-10 rounded-lg">
                            </td>
                            <td class="text-left py-3 px-12 text-white/60">${
                                user.student?.nis || "-"
                            }</td>
                            <td class="text-left py-3 px-3 text-white/60">${
                                user.email || "-"
                            }</td>
                            <td class="text-left py-3 px-3 text-white/60">${
                                user.student?.name || "-"
                            }</td>
                            <td class="text-left py-3 px-3 text-white/60">${
                                user.student?.class || "-"
                            }</td>
                            <td class="text-left py-3 px-3 text-white/60">
                                <span class="inline-flex items-left wdsR bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                    belum bayar
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <div class="gap-3 flex">
                                    <button class="text-white/50 hover:text-blue-400 transition wdshB duration-300 edit-btn"
                                        data-id="${user.id}"
                                        data-nis="${user.student?.nis || ""}"
                                        data-email="${user.email || ""}"
                                        data-name="${user.student?.name || ""}"
                                        data-class="${
                                            user.student?.class || ""
                                        }"
                                        data-avatar="${user.avatar || ""}">
                                        <i class="fa-solid fa-pen-to-square text-base"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                    });
                }

                tableBody.innerHTML = html;

                // Reinit Alpine.js
                if (window.Alpine && window.Alpine.initTree) {
                    window.Alpine.initTree(tableBody);
                }
            });
    });
});
