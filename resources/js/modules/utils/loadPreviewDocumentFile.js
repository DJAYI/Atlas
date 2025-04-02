const fileInput = document.getElementById("identity_document");
const previewImage = document.getElementById("preview-image");

// Event listener for file input
fileInput.addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
        previewImage.classList.remove("hidden"); // Show the image if a file is selected
    } else {
        previewImage.src = "";
        previewImage.classList.add("hidden"); // Hide the image if no file is selected
    }
});
