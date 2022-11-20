if (screen.width < 560) {
    document.getElementById("offcanvasRight").classList.remove("offcanvas-end");
    document.getElementById("offcanvasRight").classList.add("offcanvas-bottom");
    document.getElementById("offcanvasExample").classList.remove("offcanvas-start");
    document.getElementById("offcanvasExample").classList.add("offcanvas-bottom");
}

/*********************************** Text Box Validation ****************************/

// Validate text box area
var userInput = document.getElementById("userText");
var resultLength = document.getElementById("result");
var limit = 280;
var minlimit = 0;
var textLimitInvalid = true;
var altLimitInvalid = true;

resultLength.textContent = 0 + "/" + limit;
//document.getElementById("userText").required = true;
userInput.required = true;


userInput.addEventListener("keyup", function (e) {
    e.preventDefault()
    var userTextLength = userInput.value.trim();
    //var textLength = userInput.value.length;
    var textLength = userTextLength.length;
    resultLength.textContent = textLength + "/" + limit;
    // If user enters more than 280 characters or text box is empty(spaces are not allowed)
    // border color and limit color will be red
    if (textLength <= minlimit || textLength > limit) {
        userInput.style.borderColor = "#ff2851";
        resultLength.style.color = "#ff2851";
        textLimitInvalid = false;
    }

    // User enters a maximum of 280 characters, border and limit color are set to green
    else {
        userInput.style.borderColor = "#008000";
        resultLength.style.color = "#008000";
        textLimitInvalid = true;
    }

    setButton();
});

/*********************************** Image Description Validation *********************************/

const userImage = document.getElementById("userImage");
const previewDisplayed = document.getElementById("imagePreview");
const previewImage = previewDisplayed.querySelector(".image-preview__image");
const previewDefaultText = previewDisplayed.querySelector(".image-preview__default-text");
const imageDescription = document.getElementById("altText");
//const userText = document.getElementById("userText");
const submitButton = document.getElementById("theSubmitButton");
var imageResultLength = document.getElementById("imageResult");
var imageLimit = 50;
var minImageLimit = 0;
imageResultLength.textContent = 0 + "/" + imageLimit;

document.getElementById("altText").disabled = true;

imageDescription.addEventListener("keyup", function (e){
    e.preventDefault()
    var userDescriptionLength = imageDescription.value.trim();
    var imageTextLength = userDescriptionLength.length;
    imageResultLength.textContent = imageTextLength + "/" + imageLimit;
    // If user enters more than 50 characters or text box is empty (spaces are not allowed)
    // border color and limit color will be red
    if (imageTextLength <= minImageLimit || imageTextLength > imageLimit) {
        imageDescription.style.borderColor = "#ff2851";
        imageResultLength.style.color = "#ff2851";
        altLimitInvalid = false;
    }
    //User enters less than 50, border and limit color are set to green
    else {
        imageDescription.style.borderColor = "#008000";
        imageResultLength.style.color = "#008000";
        altLimitInvalid = true;
    }

    setButton();
});

/******************************** User Image Validation **************************************/
userImage.addEventListener("change", function () {
    //e.preventDefault()
    const file = this.files[0];
    const fileExtension = ["jpeg", "JPEG", "jpg", "JPG", "png", "PNG",
        "gif", "GIF", "BMP", "bmp"];
    //const fileExt = fileExt.toLowerCase();

    if (file && fileExtension) {
        document.getElementById("altText").disabled = false;
        document.getElementById("altText").required = true;
        const reader = new FileReader();
        previewDefaultText.style.display = "none";
        previewImage.style.display = "block";
        reader.addEventListener("load", function () {
            previewImage.setAttribute("src", this.result);
        });
        reader.readAsDataURL(file);
    } else {
        previewDefaultText.style.display = null;
        previewImage.style.display = null;
        document.getElementById("altText").disabled = true;
    }
});

/******************************* setButton Function *****************************/

function setButton() {
    if (textLimitInvalid && altLimitInvalid) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}