var registerContainer = document.querySelector(".registerContainer");
var registerBtn = document.getElementById("registerBtn");

registerBtn.addEventListener("click", function(){
    registerContainer.style.display = "flex";
})

var loginBtn = document.getElementById("loginBtn");
var username = document.getElementById("username");
var password = document.getElementById("password");
var errortext = document.querySelector(".error");
var makeAcountBtn = document.getElementById("makeAccount");

loginBtn.addEventListener("click", function(){
    if (username.value == "" || password.value == "")
    {
        errortext.style.display = "block";
        errortext.innerHTML = "Please enter a username and password";
    }
    else{
        errortext.style.display = "none";
        console.log("something")
    }
})