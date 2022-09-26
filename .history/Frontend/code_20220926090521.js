var registerContainer = document.querySelector(".registerContainer");
var registerBtn = document.getElementById("registerBtn");

registerBtn.addEventListener("click", function(){
    registerContainer.style.display = "flex";
})

var loginBtn = document.getElementById("loginBtn");
var username = document.getElementById("username");
var password = document.getElementById("password");
var errortext = document.querySelector("#loginerror");

loginBtn.addEventListener("click", function(){
    if (username.value == "" || password.value == "")
    {
        errortext.style.display = "block";
        errortext.innerHTML = "Please enter a username and password";
    }
    else{
        errortext.style.display = "none";
        window.location = "home.html";
        console.log("send to ewa")
    }
})

var makeAccountBtn = document.getElementById("makeAccountBtn");

var registeremail = document.getElementById("registerEmail");
var registerusername = document.getElementById("registerUsername");
var registerpassword = document.getElementById("registerPassword");
var registererrortext = document.querySelector("#registererror");

makeAccountBtn.addEventListener("click", function(){
    if (registerusername.value == "" || registerpassword.value == "" || registeremail.value == "")
    {
        registererrortext.style.display = "block";
        registererrortext.innerHTML = "Please enter a username, password and email";
    }
    else{
        registererrortext.style.display = "none";
        window.location = "home.html";
        console.log("send to ewa")
    }
})