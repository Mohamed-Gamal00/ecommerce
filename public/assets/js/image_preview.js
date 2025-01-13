const imageUpload = document.getElementById("imageUpload");
const imagePreview = document.getElementById("imagePreview");

const bgimageUpload = document.getElementById("bgimageUpload");
const bgimagePreview = document.getElementById("bgimagePreview");

// imageUpload.addEventListener("change", function () {
//     const file = this.files[0];
//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function () {
//             imagePreview.src = reader.result;
//             imagePreview.style.display = "block";
//         };
//         reader.readAsDataURL(file);
//     }
// });

document.querySelectorAll('input[type="file"]').forEach((input) => {
    input.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const previewId = this.dataset.previewTarget; // Get the target preview ID
            const imagePreview = document.getElementById(previewId); // Find the preview element by ID
            const reader = new FileReader();
            reader.onload = function () {
                if (imagePreview) {
                    imagePreview.src = reader.result;
                    imagePreview.style.display = "block";
                }
            };
            reader.readAsDataURL(file);
        }
    });
});


bgimageUpload.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            bgimagePreview.src = reader.result;
            bgimagePreview.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});
