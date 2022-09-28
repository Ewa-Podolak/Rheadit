// login

// login check

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

                console.log(data);

                if(data.userid != null){
                    errortext.style.display = "none";

                    var userid = data.userid;
                    var username = data.username;
                    window.localStorage.setItem("userid", userid);
                    window.localStorage.setItem("username", username);
                    window.location.href = "home.html";
                }
                else{
                    errortext.style.display = "block";
                    errortext.innerHTML = "Username and password dont match";
                }
            });
        }
    })

    // register check ////// needs updating on ewas side

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

            fetch(`http://localhost:8000/api/users/register/${registerusername}/${registerpassword}/${registeremail}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then((response) => response.json())
            .then((data) => {

                registererrortext.style.display = "none";
                console.log(data);
                if (data.usercreated == true){
                    registererrortext.style.display = "none";
                    window.location.href = "home.html";
                }
                else{
                    registererrortext.style.display = "block";
                    registererrortext.innerHTML = "Username already exists";
                }
            });
        }
    })

    // forgot password ///// not done on ewas side

    var forgotPassword = document.getElementById("forgotPassword");

    forgotPassword.addEventListener("click", function(){
        console.log("forgot password");

        // send password reset request ///////////////////
    })
}

// home 

var upvoted = false;
var downvoted = false;

if (!window.location.href.includes("index.html")){

    var pagenumber = 1;
    var postsContainer = document.querySelector(".postsContainer");

    // get posts for page

    getPosts(pagenumber);

    // go to home page

    var logo = document.getElementById("logo");

    logo.addEventListener("click", function(){
        window.location.href = "home.html";
    })

    // loging out

    var logoutBtn = document.getElementById("logout")

    logoutBtn.addEventListener("click", function(){
        window.location.href = "index.html"
    })

    // open / close menu

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

    // going to profile page

    var goToProfile = document.getElementById("goProfile");
    var profilePics = document.querySelectorAll("#profilePic");
    var usernames = document.querySelectorAll("#username");

    goToProfile.addEventListener("click", function(){
        window.location.href = "profile.html";
        personalProfile();
    })

    for (let y = 0; y < profilePics.length; y++){
        profilePics[y].addEventListener("click", function(){
            console.log(profilePics.length);
            console.log(username.length);
            window.location.href = "profile.html";
        })

        // other person page
    }

    function personalProfile(){
        // personal page

        var editBio = document.getElementById("editBio");
        var editProfile = document.getElementById("editProfile");

        editBio.style.display = "block";
        editProfile.style.display = "block";
    }

    // group

    if (window.location.href.includes("group.html")){

        var joinGroup = document.getElementById("joinGroup");

        joinGroup.addEventListener("click", function(){
            joinGroup.innerHTML = "Requested";
            joinGroup.style.fontWeight = "700"
        })

    }

    //comments

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

    //// posts 

    // recent or popular

    if (!window.location.href.includes("home.html")){
        var recent = true;
        var mostRecent = document.getElementById("mostRecent");
        var mostPopular = document.getElementById("mostPopular");
        mostRecent.addEventListener("click", function(){
            recent = true;
        })
        mostPopular.addEventListener("click", function(){
            recent = false;
        })
    }

    // pagenum

    var plusPageNum = document.getElementById("plusPageNum");
    var minusPageNum = document.getElementById("minusPageNum");
    var pageNum = document.getElementById("pageNum");

    plusPageNum.addEventListener("click", function(){
        pagenumber++;
        pageNum.innerHTML = pagenumber
        getPosts(pagenumber);
    })

    minusPageNum.addEventListener("click", function(){
        if (pagenumber > 1){
            pagenumber--;
            pageNum.innerHTML = pagenumber
            getPosts(pagenumber);
        }
    })

    //get posts

    function getPosts(pagenumber){
        if(postsContainer.id == "homePage"){ // homepage posts

            fetch(`http://localhost:8000/api/posts/homepage/${pagenumber}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                if(data.length == 0){
                    console.log("empty")
                    populatePosts(data);
                    postsContainer.innerHTML = "no more posts to show";
                    
                    plusPageNum.disabled = true;
                }
                else{
                    plusPageNum.disabled = false;
                    populatePosts(data);
                }
            });
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

    function populatePosts(data){
        postsContainer.innerHTML = "";
        for (let x = 0; x < data.length; x++){
            const postAndComments = document.createElement("div");
            postAndComments.classList.add("postAndComments");

            postsContainer.appendChild(postAndComments);

            // posts

            const post = document.createElement("div");
            post.classList.add("post");

            postAndComments.appendChild(post);

            const votes = document.createElement("div");
            votes.classList.add("votes");

            post.appendChild(votes);

            const arrowupBtn = document.createElement("button");
            arrowupBtn.classList.add("arrowupBtn");

            const arrowup = document.createElement("i");
            arrowup.classList.add("fa-solid", "fa-circle-arrow-up");

            const numVotes = document.createElement("h2");
            numVotes.innerHTML = data[x].votes
            votes.id = numVotes

            const arrowdownBtn = document.createElement("button");
            arrowdownBtn.classList.add("arrowdownBtn");

            const arrowdown = document.createElement("i");
            arrowdown.classList.add("fa-solid", "fa-circle-arrow-down"); 

            arrowupBtn.appendChild(arrowup);
            votes.appendChild(arrowupBtn);
            votes.appendChild(numVotes);
            arrowdownBtn.appendChild(arrowdown);
            votes.appendChild(arrowdownBtn);

            const thePost = document.createElement("div");
            thePost.classList.add("thePost");

            post.appendChild(thePost);

            const profile = document.createElement("div");
            profile.classList.add("profile");

            thePost.appendChild(profile);

            const profilePic = document.createElement("img");
            profilePic.id = "profilePic" 
            profilePic.src = "./images/607426-200.png" // change

            const usernameEl = document.createElement("h2");
            usernameEl.id = "username";
            usernameEl.innerHTML = data[x].username

            profile.appendChild(profilePic);
            profile.appendChild(usernameEl);

            const postImgTxt = document.createElement("div");
            postImgTxt.classList.add("postImgTxt");

            thePost.appendChild(postImgTxt);

            const HeadtextEl = document.createElement("h2");
            HeadtextEl.id = "text" 
            HeadtextEl.innerHTML = data[x].head; 

            const BodytextEl = document.createElement("h3");
            BodytextEl.id = "body" 
            BodytextEl.innerHTML = data[x].body; 

            // const postImg = document.createElement("img"); ///// if has image
            // postImg.src = "" ///// if has image

            postImgTxt.appendChild(HeadtextEl);
            postImgTxt.appendChild(BodytextEl);
            // postImgTxt.appendChild(postImg); ///// if has image

            const interactions = document.createElement("div");
            interactions.classList.add("interactions");

            thePost.appendChild(interactions);

            const commentbtnEl = document.createElement("button");
            commentbtnEl.classList.add("commentbtn");
            commentbtnEl.innerHTML = "Tails";

            interactions.appendChild(commentbtnEl);

            var userid = window.localStorage.getItem("userid");

            arrowup.addEventListener("click", function(){

                console.log("arrowup clicked");

                fetch(`http://localhost:8000/api/posts/upvote/${x+1}/${userid}`, { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    if (data.upvoted == true){
                        arrowupBtn.style.backgroundColor = "red";
                    }
                });

                
            });

            arrowdown.addEventListener("click", function(){

                console.log("arrowdown clicked");

                fetch(`http://localhost:8000/api/posts/downvote/${x+1}/${userid}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    if (data.downvote == true){
                        arrowdownBtn.style.backgroundColor = "red";
                    }
                });

            });


            // comments

        }
    }
}
