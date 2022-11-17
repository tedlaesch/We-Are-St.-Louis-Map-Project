/*!
* Start Bootstrap - Bare v5.0.7 (https://startbootstrap.com/template/bare)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-bare/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project


var textError = document.getElementById('text-error')
var imageError = document.getElementById('image-error')
var form = document.getElementById('inputForm')

function validateText(){
    var inputText = document.getElementById("userText").value;
    if(inputText.length == 0){
        textError.innerHTML = "Text is required";
        return false;
    }
    if(inputText.length > 280){
        textError.innerHTML = "Length must be 280 characters maximum";
        return false;
    }
    textError.innerHTML= "valid";
    return true;

}
//
/*
form.addEventListener('submit', (e)=>{
    var inputText = document.getElementById("userText").value;
    let message =[];
    if(inputText.value === 0 || inputText.value === " ") {
        message.push("Text is required");
    }
    if(inputText.value.length > 280){
        message.push("Length must be 280 characters maximum";
    }
    if(message.length > 0 && messag0e.length < 280){
        e.preventDefault()
        textError.innerText = message.join(', ')
    }
    3
})
*/


let input = document.querySelector('userImage')
let span = document.querySelector('span');
input.addEventListener('change', () =>{
    let files = input.files;
    if(files.length > 0){
        if(files[0].size > 10 * 1024){
            imageError.innerText = "File size exceeds 10 kb";
            return;
        }
    }
    imageError.innerText = '';
})

