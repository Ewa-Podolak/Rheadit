var registerContainer = document.querySelector(".registerContainer");
var registerBtn = document.getElementById("registerBtn");

registerBtn.addEventListener("click", function(){
    registerContainer.style.display = "flex";
})

var loginBtn = document.getElementById("loginBtn");
var username = document.getElementById("username");
var password = document.getElementById("password");
var errortext = document.querySelector(".error");

loginBtn.addEventListener("click", function(){
    if (username.value == "" || password.value == "")
    {
        errortext.style.display = "block";
        errortext.innerHTML = "Please enter a username and password";
    }
    else{
        errortext.style.display = "none";
        console.log("send to ewa")
    }
})

var makeAccountBtn = document.getElementById("#makeAccount");
var email = document.getElementById("registerEmail");
var username = document.getElementById("registerUsername");
var password = document.getElementById("registerPassword");
var errortext = document.querySelector(".registererror");
var makeAcountBtn = document.getElementById("makeAccount");

loginBtn.addEventListener("click", function(){
    if (username.value == "" || password.value == "")
    {
        errortext.style.display = "block";
        errortext.innerHTML = "Please enter a username and password";
    }
    else{
        errortext.style.display = "none";
        console.log("send to ewa")
    }
})