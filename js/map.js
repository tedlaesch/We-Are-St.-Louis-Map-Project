if (screen.width < 560) {
    document.getElementById("offcanvasRight").classList.remove("offcanvas-end");
    document.getElementById("offcanvasRight").classList.add("offcanvas-bottom");
    document.getElementById("offcanvasExample").classList.remove("offcanvas-start");
    document.getElementById("offcanvasExample").classList.add("offcanvas-bottom");
}


/**********************************************************************************************/

// Validate text box area
    var userInput = document.getElementById("userText");
    var resultLength = document.getElementById("result");
    var limit = 280;
    resultLength.textContent = 0 + "/" + limit;

    userInput.addEventListener("keyup", function () {
        var textLength = userInput.value.length;
        resultLength.textContent = textLength + "/" + limit;
        // if user enters more than 280 characters, border color and limit color will be red
        if (textLength > limit) {
            userInput.style.borderColor = "#ff2851";
            resultLength.style.color = "#ff2851";
        }
        // If characters are less than 280, border and limit color are set to green
        else {
            userInput.style.borderColor = "#008000";
            resultLength.style.color = "#008000";
        }
    });
    /**********************************************************************************************/


    const userImage = document.getElementById("userImage");
    const previewDisplayed = document.getElementById("imagePreview");
    const previewImage = previewDisplayed.querySelector(".image-preview__image");
    const previewDefaultText = previewDisplayed.querySelector(".image-preview__default-text");
    const imageDescription = document.getElementById("imageDescription");
    var imageResultLength = document.getElementById("imageResult");
    var imageLimit = 25;
    imageResultLength.textContent = 0 + "/" + imageLimit;

    userImage.addEventListener("change", function () {
        const file = this.files[0];

        if (file) {
            document.getElementById("imageDescription").disabled=true;
            const reader = new FileReader();
            previewDefaultText.style.display = "none";
            previewImage.style.display = "block";
            reader.addEventListener("load", function () {
                previewImage.setAttribute("src", this.result);
            });
            reader.readAsDataURL(file);
        }

        // User did not upload a picture
        else {
            previewDefaultText.style.display = null;
            previewImage.style.display = null;
                document.getElementById("imageDescription").disabled = false;

                imageDescription.addEventListener("keyup", function () {
                    var imageTextLength = imageDescription.value.length;
                    imageResultLength.textContent = imageTextLength + "/" + imageLimit;
                    // if user enters more than 280 characters, border color and limit color will be red
                    if (imageTextLength > imageLimit) {
                        imageDescription.style.borderColor = "#ff2851";
                        imageResultLength.style.color = "#ff2851";
                    }
                    // If characters are less than 280, border and limit color are set to green
                    else {
                        imageDescription.style.borderColor = "#008000";
                        imageDescription.style.color = "#008000";
                    }
                });

        }
    });

/*********************************************************************************************/

