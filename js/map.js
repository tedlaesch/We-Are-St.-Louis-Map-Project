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
var textLimitValid = true;
var altLimitValid = true;
var locationValid = false;


resultLength.textContent = 0 + "/" + limit;
//document.getElementById("userText").required = true;
userInput.required = true;

document.addEventListener('DOMContentLoaded', function () {
    // Make sure to run validation one time right when the site loads
    setButton();
    // Also add additional form elements for coordinates
    var submitForm = document.getElementById('inputForm');
    var inputLat = document.createElement('input');
    inputLat.setAttribute('name', "coord[lat]");
    inputLat.setAttribute('value', 0);
    inputLat.setAttribute('type', "hidden");
    var inputLng = document.createElement('input');
    inputLng.setAttribute('name', "coord[lng]");
    inputLng.setAttribute('value', 0);
    inputLng.setAttribute('type', "hidden");
    submitForm.appendChild(inputLat);
    submitForm.appendChild(inputLat);
});

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
        textLimitValid = false;
    }

    // User enters a maximum of 280 characters, border and limit color are set to green
    else {
        userInput.style.borderColor = "#008000";
        resultLength.style.color = "#008000";
        textLimitValid = true;
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
altTextCountDef = imageResultLength.style.color;
altTextBorderDef = imageDescription.style.borderColor;

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
        altLimitValid = false;
    }
    //User enters less than 50, border and limit color are set to green
    else {
        imageDescription.style.borderColor = "#008000";
        imageResultLength.style.color = "#008000";
        altLimitValid = true;
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

/******************************* Reset Image Function *****************************/
function resetFile() {
     userImage.value = ""; //reset image
     const image = document.getElementById("imgPre");
        image.src= ""; //reset preview
     const text= document.getElementById("altText");
        text.value="";
        text.disabled = true; //resets the desrciption textbox to empty and disabled since no picture is selected
        previewDefaultText.style.display = null;
        previewImage.style.display = null;
        imageDescription.style.borderColor = altTextBorderDef;
        imageResultLength.style.color = altTextCountDef;
        altLimitValid = true;
        imageResultLength.textContent = 0 + "/" + imageLimit;
        setButton();
}

/******************************* setButton Function *****************************/

function setButton() {
    if (textLimitValid && altLimitValid && locationValid) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

function mapClicked(lat, lng) {
    if (lat != 0 && lng != 0) {
        // 0, 0 is technically a valid coordinate but all that is there is a weather buoy so we're using it as the "invalid" coordinate
        locationValid = true;
        document.getElementById("selectLocationMessage").style = "display: none";
        document.getElementsByName("coord[lat]")[0].value = lat;
    } else {
        locationValid = false;
        document.getElementById("selectLocationMessage").style = "";
        document.getElementsByName("coord[lng]")[0].value = lng;
    }
    setButton();
}