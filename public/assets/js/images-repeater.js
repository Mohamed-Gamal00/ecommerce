window.onload = function () {
  addImageUpload();
};

function previewImage(event, index) {
  const input = event.target;
  const reader = new FileReader();
  reader.onload = function () {
    const preview = document.getElementById(`preview-${index}`);
    preview.src = reader.result;
  };
  reader.readAsDataURL(input.files[0]);
}

function removeImage(index) {
  const preview = document.getElementById(`preview-${index}`);
  const input = document.getElementById(`file-ip-${index}`);
  input.value = "";
  const container = document.querySelector(
    `.image-upload-container #image-upload-${index}`
  );
  container.parentNode.removeChild(container);
}

let uploadIndex = 2; // Start with 2 as there's already one input

function addImageUpload() {
  const container = document.querySelector(".image-upload-container");
  const newInput = document.createElement("div");
  newInput.classList.add("image-upload-one");
  newInput.innerHTML = `
                  						<div class="image-upload-container"> 

       <div class="image-upload-one" id="image-upload-${uploadIndex}">
        <div class="center">
            <div class="form-input">
                <label for="file-ip-${uploadIndex}">
                    <div class="image-container">
                        <img alt="Preview" src="" data-holder-rendered="true" id="preview-${uploadIndex}">
                        <div class="overlay"></div>
                        <input type="file" hidden id="file-ip-${uploadIndex}" name="header[${uploadIndex}][image]" accept="image/*" onchange="previewImage(event, ${uploadIndex})">
                        <button class="button-remove2" type="button" onclick="removeImage(${uploadIndex})">x</button>
                        
                    </div>

                </label>
                                    <input type="text" name="header[${uploadIndex}][image_link]" placeholder="ضع رابط الصوره هنا" class="form-control">

            </div>
        </div>
      </div>
    `;
  container.appendChild(newInput);

  const baseUrl = window.location.origin;
  const relativeImagePath = "/assets/images/upload-image.jpg";
  const fullImageUrl = baseUrl + relativeImagePath;
  document.getElementById(`preview-${uploadIndex}`).src = fullImageUrl;

  newInput.style.opacity = 0;
  setTimeout(() => {
    newInput.style.opacity = 1;
  }, 10);
  uploadIndex++;
}

container.appendChild(newInput);
uploadIndex++;
