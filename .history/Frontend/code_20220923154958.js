var registerContainer = document.querySelector(".registerContainer");
var registerBtn = document.getElementById("registerBtn");

registerBtn.addEventListener("click", function(){
    registerContainer.style.display = "flex";
})

var loginBtn = document.getElementById("loginBtn");
var username = document.getElementById("username");
var password = document.getElementById("password");
var makeAcountBtn = document.getElementById("makeAccount");

loginBtn.addEventListener("click", function(){
    if (username.input == "")
    {
        console.log("nothing")
    }
    else{
        console.log("something")
    }
})