document.addEventListener("DOMContentLoaded", () => {
    const photoInput = document.getElementById("photo");
    const previewImage = document.getElementById("preview-image");
    const previewPlaceholder = document.getElementById("preview-placeholder");
    const fileInfo = document.getElementById("file-info");
    const fileName = document.getElementById("file-name");

    if (!photoInput) return;

    photoInput.addEventListener("change", previewPhoto);

    function previewPhoto(event) {
        const file = event.target.files[0];

        if (file) {
            const validTypes = ["image/jpeg", "image/jpg", "image/png"];
            if (!validTypes.includes(file.type)) {
                alert("File harus berformat JPG, JPEG, atau PNG");
                event.target.value = "";
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert("Ukuran file maksimal 2MB");
                event.target.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove("hidden");
                previewPlaceholder.classList.add("hidden");
            };
            reader.readAsDataURL(file);

            fileName.textContent = file.name;
            fileInfo.classList.remove("hidden");
        } else {
            resetPhoto();
        }
    }

    window.removePhoto = function () {
        photoInput.value = "";
        resetPhoto();
    };

    function resetPhoto() {
        previewImage.src = "";
        previewImage.classList.add("hidden");
        previewPlaceholder.classList.remove("hidden");
        fileInfo.classList.add("hidden");
    }

    // Drag & drop
    const photoLabel = document.querySelector('label[for="photo"]');
    const dropArea = photoLabel?.querySelector("div");

    if (!dropArea) return;

    ["dragenter", "dragover", "dragleave", "drop"].forEach((e) =>
        dropArea.addEventListener(e, preventDefaults)
    );

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ["dragenter", "dragover"].forEach((e) =>
        dropArea.addEventListener(e, () =>
            dropArea.classList.add("border-blue-400", "bg-blue-50")
        )
    );

    ["dragleave", "drop"].forEach((e) =>
        dropArea.addEventListener(e, () =>
            dropArea.classList.remove("border-blue-400", "bg-blue-50")
        )
    );

    dropArea.addEventListener("drop", (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            photoInput.files = files;
            previewPhoto({ target: { files } });
        }
    });
});
