// login

if (window.location.href.includes("index.html")){

    var loginBtn = document.getElementById("loginBtn");
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var errortext = document.querySelector("#loginerror");

    username = username.value;
    password = username.value;


    fetch(`http://localhost:8000/api/users/login/${username}/${password}`)
    .then(response => response.json())
    .then(data => {
    
        loginBtn.addEventListener("click", function(){
            if (username.value == "" || password.value == "")
            {
                errortext.style.display = "block";
                errortext.innerHTML = "Please enter a username and password";
            }
            else{
                errortext.style.display = "none";
                // window.location.href = "home.html";
                console.log(username.value);
                console.log(password.value);
                console.log(data);
            }
        })
    });

    var registerContainer = document.querySelector(".registerContainer");
    var registerBtn = document.getElementById("registerBtn");

    registerBtn.addEventListener("click", function(){
        registerContainer.style.display = "flex";
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


if (!window.location.href.includes("index.html")){

    var goToProfile = document.getElementById("goProfile");
    var profilePics = document.querySelectorAll("#profilePic");

    goToProfile.addEventListener("click", function(){
        window.location.href = "profile.html";
    })

    for (let y = 0; y < profilePics.length; y++){
        profilePics[y].addEventListener("click", function(){
            window.location.href = "profile.html";
        })
    }

    var commentBtns = document.querySelectorAll(".commentbtn");
    var comments = document.querySelectorAll(".comments");
    var posts = document.querySelectorAll(".post");
    var comsDispalyedArray = new Array(commentBtns.length).fill(false);
    
    for (let x = 0; x < commentBtns.length; x++){
        commentBtns[x].addEventListener('click', event => {
            if (comsDispalyedArray[x] == false){
                comments[x].style.display = "flex";  
                posts[x].style.borderBottomRightRadius = "0";            
                posts[x].style.borderBottomLeftRadius = "0";  
                comsDispalyedArray[x] = true;
            }          
            else{
                comments[x].style.display = "none";  
                posts[x].style.borderBottomRightRadius = "15px";            
                posts[x].style.borderBottomLeftRadius = "15px";  
                comsDispalyedArray[x] = false;
            }
        });
    }
    
    var hamburger = document.querySelector(".hamburger");
    var dropDown = document.querySelector(".dropDown");
    var dropDownDisplay = false;
    
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


    var logo = document.getElementById("logo");

    logo.addEventListener("click", function(){
        window.location.href = "home.html";
    })

    var logoutBtn = document.getElementById("logout")

    logoutBtn.addEventListener("click", function(){
        window.location.href = "index.html"
    })


    // posts 

    var postsContainer = document.querySelector(".postsContainer");
    var recent = true;

    var mostRecent = document.getElementById("mostRecent");
    var mostPopular = document.getElementById("mostPopular");
    mostRecent.addEventListener("click", function(){
        recent = true;
    })
    mostPopular.addEventListener("click", function(){
        recent = false;
    })

    if(postsContainer.id == "homePage"){
        //get homepage posts
    }
    else if (postsContainer.id == "profilePage"){
        if(recent){
            // show recent profile posts
        }
        else{
            // show popular profile posts
        }
    }
    else if (postsContainer.id == "groupPage"){
        if(recent){
            // show recent group posts
        }
        else{
            // show popular group posts
        }
    }
}

// group

if (window.location.href.includes("group.html")){

    var joinGroup = document.getElementById("joinGroup");

    joinGroup.addEventListener("click", function(){
        joinGroup.innerHTML = "Requested";
        joinGroup.style.fontWeight = "700"
    })

}
