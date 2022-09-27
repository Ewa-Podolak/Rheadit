// login

console.log(window.location.href)

if (window.location.href.includes("index.html")){

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
            window.location.href = "home.html";
            console.log("send to ewa")
        }
    })

    var forgotPassword = document.getElementById("forgotPassword");

    forgotPassword.addEventListener("click", function(){
        console.log("forgot password");
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
            window.location.href = "home.html";
            console.log("send to ewa")
        }
    })
}

// home


if (window.location.href.includes("home.html")){

    var hamburger = document.querySelector(".hamburger");
    var dropDown = document.querySelector(".dropDown");
    var dropDownDisplay = false;
    console.log(dropDown);

    hamburger.addEventListener("click", function(){
        if (dropDownDisplay == false)
        {
            dropDown.style.display = "flex";
            dropDownDisplay = true;
        }
        else{
            dropDown.style.display = "none";
            dropDownDisplay = false;
        }
    })
}

var commentBtns = document.querySelectorAll(".commentbtn");
var comments = document.querySelectorAll(".comments");
var posts = document.querySelectorAll(".post");
var commentsdisplayed = false;
var array = new Array(5).fill(false);
console.log(array);

for (let x = 0; x < commentBtns.length; x++){
    commentBtns[x].addEventListener('click', event => {
        if (!commentsdisplayed){
            comments[x].style.display = "flex";  
            posts[x].style.borderBottomRightRadius = "0";            
            posts[x].style.borderBottomLeftRadius = "0";  
            commentsdisplayed = true;
        }          
        else{
            comments[x].style.display = "none";  
            posts[x].style.borderBottomRightRadius = "15px";            
            posts[x].style.borderBottomLeftRadius = "15px";  
            commentsdisplayed = false;
        }
    });
}
