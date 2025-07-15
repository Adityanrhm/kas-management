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
            role: "",
        },
        previewImage: "",
        fileName: "",

        init() {
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
                role: "",
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
            this.formAction = `/master/siswa/update/${data.id}`;
            this.formData = {
                nis: data.nis || "",
                email: data.email || "",
                name: data.name || "",
                class: data.class || "",
                role: data.role || "",
            };

            // Set preview image jika ada avatar
            if (data.avatar) {
                this.previewImage = `${window.storageUrl}/${data.avatar}`;
                console.log(data);
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
        results: window.initialData.data || [],
        pagination: {
            current_page: window.initialData.current_page || 1,
            last_page: window.initialData.last_page || 1,
            next_page_url: window.initialData.next_page_url || null,
            prev_page_url: window.initialData.prev_page_url || null,
            from: window.initialData.from || 0,
            to: window.initialData.to || 0,
            total: window.initialData.total || 0,
        },

        // Initial data dari window variable
        originalData: window.initialData || [],
        loading: false,
        searchTimeout: null,

        init() {
            console.log(this.results);
        },

        get visiblePages() {
            const maxVisible = 3; // Jumlah halaman yang ingin ditampilkan
            const current = this.pagination.current_page;
            const last = this.pagination.last_page;

            if (last <= maxVisible) {
                // Jika total halaman <= maxVisible, tampilkan semua
                return Array.from({ length: last }, (_, i) => i + 1);
            }

            let start = Math.max(1, current - Math.floor(maxVisible / 2));
            let end = Math.min(last, start + maxVisible - 1);

            // Penyesuaian jika berada di awal atau akhir
            if (end - start + 1 < maxVisible) {
                start = Math.max(1, end - maxVisible + 1);
            }

            return Array.from({ length: end - start + 1 }, (_, i) => start + i);
        },

        performSearch() {
            // Clear previous timeout
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            // Set loading state
            this.loading = true;

            // Debounce search
            this.searchTimeout = setTimeout(() => {
                this.fetchData();
            });
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
                this.results = data.data;
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    from: data.from,
                    to: data.to,
                    total: data.total,
                };
            } catch (error) {
                console.error("Search error:", error);
                // Show error to user
                this.results = [];
            } finally {
                this.loading = false;
            }
        },
        changePage(pageUrl) {
            if (!pageUrl) return;
            this.loading = true;
            fetch(pageUrl, {
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
            })
                .then((response) => response.json())
                .then((data) => {
                    this.results = data.data;
                    this.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page,
                        next_page_url: data.next_page_url,
                        prev_page_url: data.prev_page_url,
                        from: data.from,
                        to: data.to,
                        total: data.total,
                    };
                })
                .catch((error) => {
                    console.error("Pagination error:", error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    };
}

// Export functions untuk penggunaan global
window.searchData = searchData;
window.siswaModal = siswaModal;
