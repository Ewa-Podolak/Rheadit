// login

if (window.location.href.includes("index.html")){

    var loginBtn = document.getElementById("loginBtn");
    var errortext = document.querySelector("#loginerror");

    loginBtn.addEventListener("click", function(){
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        if (username == "" || password == "")
        {
            errortext.style.display = "block";
            errortext.innerHTML = "Please enter a username and password";
        }
        else{
            fetch(`http://localhost:8000/api/users/login/${username}/${password}`)
            .then(response => response.json())
            .then(data => { 

                if(data.loggedin == true){
                    errortext.style.display = "none";
                    window.location.href = "home.html";
                }
                else{
                    errortext.style.display = "block";
                    errortext.innerHTML = "Username and password dont match";
                }
            });
        }
    })

    var registerContainer = document.querySelector(".registerContainer");
    var registerBtn = document.getElementById("registerBtn");

    registerBtn.addEventListener("click", function(){
        registerContainer.style.display = "flex";
    })


    var makeAccountBtn = document.getElementById("makeAccountBtn");
    var registererrortext = document.querySelector("#registererror");

    makeAccountBtn.addEventListener("click", function(){

        var registeremail = document.getElementById("registerEmail").value;
        var registerusername = document.getElementById("registerUsername").value;
        var registerpassword = document.getElementById("registerPassword").value;

        if (registerusername == "" || registerpassword == "" || registeremail == "")
        {
            registererrortext.style.display = "block";
            registererrortext.innerHTML = "Please enter a username, password and email";
        }
        else{

            fetch(`http://localhost:8000/api/users/register/{username}/{pasword}/{email}`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            });


            // registererrortext.style.display = "none";
            // window.location.href = "home.html";
            // console.log("send to ewa")
        }
    })



    var forgotPassword = document.getElementById("forgotPassword");

    forgotPassword.addEventListener("click", function(){
        console.log("forgot password");

        // send password reset request
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
