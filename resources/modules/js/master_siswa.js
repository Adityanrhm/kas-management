// master_siswa.js
function siswaModal() {
    return {
        isEdit: false,
        formAction: "",
        previewImage: "",
        fileName: "",
        formData: {
            id: "",
            nis: "",
            email: "",
            name: "",
            class: "",
        },

        // Initialize the modal with default values
        init() {
            // Set default form action and NIS if available
            this.formAction = this.getRoute("master.store.siswa");
            this.formData.nis = this.getDefaultNis();

            // Ensure isEdit is false on initialization
            this.isEdit = false;
        },

        resetForm() {
            this.isEdit = false;
            this.formAction = this.getRoute("master.store.siswa");
            this.previewImage = "";
            this.fileName = "";
            this.formData = {
                id: "",
                nis: this.getDefaultNis(),
                email: "",
                name: "",
                class: "",
            };

            // Reset form fields with timeout to ensure DOM is ready
            setTimeout(() => {
                const photoInput = document.getElementById("photo");
                const passwordInput = document.getElementById("password");
                const passwordConfirmInput = document.getElementById(
                    "password_confirmation"
                );

                if (photoInput) photoInput.value = "";
                if (passwordInput) passwordInput.value = "";
                if (passwordConfirmInput) passwordConfirmInput.value = "";
            }, 100);
        },

        editForm(data) {
            this.isEdit = true;
            this.formAction = `/master/siswa/${data.id}`;
            this.formData = {
                id: data.id,
                nis: data.nis,
                email: data.email,
                name: data.name,
                class: data.class,
            };

            // Set preview image if exists
            if (data.avatar) {
                this.previewImage = this.getStorageUrl() + "/" + data.avatar;
            } else {
                this.previewImage = "";
            }
        },

        previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        removePhoto() {
            this.previewImage = "";
            this.fileName = "";
            const photoInput = document.getElementById("photo");
            if (photoInput) photoInput.value = "";
        },

        // Helper methods to get Laravel routes and values
        getRoute(routeName) {
            // This will be set from the blade template
            return window.routes && window.routes[routeName]
                ? window.routes[routeName]
                : "";
        },

        getDefaultNis() {
            // This will be set from the blade template
            return window.defaultNis || "";
        },

        getStorageUrl() {
            // This will be set from the blade template
            return window.storageUrl || "";
        },
    };
}

// Make the function globally available
window.siswaModal = siswaModal;
