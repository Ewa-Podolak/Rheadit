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
                    window.localStorage.setItem("usernameToGet", username);
                    window.location.href = "home.html";
                }
                else{
                    errortext.style.display = "block";
                    errortext.innerHTML = "Username and password dont match or account does not exist";
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

                if (data.userid != null){

                    var userid = data.userid;
                    var username = data.username;
                    window.localStorage.setItem("userid", userid);
                    window.localStorage.setItem("username", username);
                    window.localStorage.setItem("usernameToGet", username);

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



// all pages

if (!window.location.href.includes("index.html")){
    var pagenumber = 1;
    var postsContainer = document.querySelector(".postsContainer");

    getPosts(pagenumber);

    // going to own profile page

        var goToProfile = document.getElementById("goProfile");
        goToProfile.addEventListener("click", function(){
            window.location.href = "profile.html";
            window.localStorage.setItem("personal", true);
        })

    // pagenum

        if (window.location.href.includes("home.html")){
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
        }

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




    // profile

        if(window.location.href.includes("profile")){

            var personal = window.localStorage.getItem("personal");
            var usernameProfile = window.localStorage.getItem("usernameToGet");

            var usernameText = document.getElementById("usernameText");
            var followers = document.getElementById("numOfFollowers");
            var following = document.getElementById("numOfFollowing");
            var bioText = document.getElementById("bioText");
            var profilePicture = document.querySelector(".profilepagePic");

            fetch(`http://localhost:8000/api/users/${usernameProfile}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                usernameText.innerHTML = usernameProfile;
                bioText.innerHTML = data.bio;
                followers.innerHTML = data.followers;
                following.innerHTML = data.following;
                if (!data.profilepic == "null")
                {
                    profilePicture.src = data.profilepic;
                }
                else{
                    profilePicture.src = "./images/607426-200.png";
                    // "./images/photo-1453728013993-6d66e9c9123a.jpeg"
                    // "./images/607426-200.png"
                }
            });

            var followersBtn = document.querySelector(".followers");
            var followingBtn = document.querySelector(".following");
            var followersOrFollowingListContainer = document.querySelector(".followersOrFollowingListContainer");
            var boxContents = document.querySelector(".boxContents");


            followersBtn.addEventListener("click", function(){
                followersOrFollowingListContainer.style.display = "flex";
                
                boxContents.innerHTML = "k"

                fetch(`http://localhost:8000/api/followers/list/followers/${usernameProfile}`) /////////// not giving anything
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // reset // boxContents.innerHTML = "Followers: "
                    // for loop in each follower
                    // boxContents.innerHTML += data.follower
                });

                var closeFollowers = document.querySelector("#closeBtn");
                closeFollowers.addEventListener("click", function(){
                    followersOrFollowingListContainer.style.display = "none"
                })
            })

            followingBtn.addEventListener("click", function(){
                followersOrFollowingListContainer.style.display = "flex";

                fetch(`http://localhost:8000/api/followers/list/followed/${usernameProfile}`) /////////// not giving anything
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // reset // boxContents.innerHTML = "Following: "
                    // for loop in each following
                    // boxContents.innerHTML += data.following
                });

                var closeFollowing = document.querySelector("#closeBtn");
                closeFollowing.addEventListener("click", function(){
                    followersOrFollowingListContainer.style.display = "none"
                })
            })

            if (personal == "true"){
                var editBio = document.getElementById("editBio");
                var editProfile = document.getElementById("editProfile");
                var newBio = document.getElementById("newBio");
                var newBioBtn = document.getElementById("newBioBtn");
        
                editBio.style.display = "block";
                editProfile.style.display = "block";

                editBio.addEventListener("click", function(){
                    newBio.style.display = "block";
                    newBioBtn.style.display = "block";
                    newBioBtn.addEventListener("click", function(){
                        bioText.innerHTML = newBio.value;

                        fetch(`http://localhost:8000/api/users/bio/${window.localStorage.getItem("userid")}/${newBio.value}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        })
                        .then((response) => response.json())
                        .then((data) => {
                                console.log(data);
                        });
                    })
                })

                editProfile.addEventListener("click", function(){
                    var profilePicEditorContainer = document.querySelector(".profilePicEditorContainer");
                    profilePicEditorContainer.style.display = "flex"
                    var close = document.querySelector(".close");
                    var submitNewProfilePic = document.querySelector("#submitNewProfilePic");
                    var submitNewProfilePicBox = document.getElementById("submitNewProfilePicBox");
                    close.addEventListener("click", function(){
                        profilePicEditorContainer.style.display = "none"
                    })
                    submitNewProfilePic.addEventListener("click", function(){ 
                        var linktopicture = submitNewProfilePicBox.value;
                        var userid = window.localStorage.getItem("userid");

                        fetch(`http://localhost:8000/api/users/profilepicture/${userid}/${linktopicture}`, { /// not working
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        })
                        .then((response) => response.json())
                        .then((data) => {
                                console.log(data);

                                profilePicEditorContainer.style.display = "none"     
                        });
                    })
                })
            }

            
        }


    // groups // needs api

        if (window.location.href.includes("group.html")){

            var joinGroup = document.getElementById("joinGroup");

            joinGroup.addEventListener("click", function(){
                joinGroup.innerHTML = "Requested";
                joinGroup.style.fontWeight = "700"
            })

        }

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

    // //get posts

    function getPosts(pagenumber){
        if(postsContainer.id == "homePage"){

            var userid = window.localStorage.getItem("userid");

            fetch(`http://localhost:8000/api/posts/homepage/${pagenumber}/${userid}`)
            .then(response => response.json())
            .then(data => {
                console.log(data)

                if(data.length == 0){
                    populatePosts(data, pagenumber);
                    postsContainer.innerHTML = "no more posts to show";
                    
                    plusPageNum.disabled = true;
                }
                else{
                    plusPageNum.disabled = false;
                    populatePosts(data, pagenumber);
                }
            });
        }
        // else if (postsContainer.id == "profilePage"){
        //     if(recent){
        //         // show recent profile posts
        //     }
        //     else{
        //         // show popular profile posts
        //     }
        // }
        // else if (postsContainer.id == "groupPage"){
        //     if(recent){
        //         // show recent group posts
        //     }
        //     else{
        //         // show popular group posts
        //     }
        // }
    }

    function populatePosts(data, pagenumber){

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
            arrowupBtn.classList.add("arrowupBtn", "arrowBtn");

            const arrowup = document.createElement("i");
            arrowup.classList.add("fa-solid", "fa-circle-arrow-up");

            const numVotes = document.createElement("h2");
            numVotes.innerHTML = data[x].votes
            //votes.id = numVotes

            const arrowdownBtn = document.createElement("button");
            arrowdownBtn.classList.add("arrowdownBtn", "arrowBtn");

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
            profilePic.classList.add("postProfilePic");
            profilePic.src = "./images/607426-200.png" // change

            const usernameEl = document.createElement("h2");
            usernameEl.id = "username";
            usernameEl.classList.add("postUsername");
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
            commentbtnEl.innerHTML = "Tails: 0";

            interactions.appendChild(commentbtnEl);

            if(data[x].voted == "upvote"){
                arrowupBtn.style.backgroundColor = "#FAB3A9";
            }

            if(data[x].voted == "downvoted"){
                arrowdownBtn.style.backgroundColor = "#FAB3A9";
            }

            var userid = window.localStorage.getItem("userid");

            arrowupBtn.addEventListener("click", function(){

                fetch(`http://localhost:8000/api/interactions/upvotepost/${x+1}/${userid}`, { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);

                    if (data.upvoted == true){
                        arrowdownBtn.style.backgroundColor = "#F6F6F2"
                        arrowupBtn.style.backgroundColor = "#FAB3A9";
                        getPosts(1);
                    }
                });
            })

            arrowdownBtn.addEventListener("click", function(){

                    fetch(`http://localhost:8000/api/interactions/downvotepost/${x+1}/${userid}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log(data);

                        if (data.downvote == true){
                            arrowupBtn.style.backgroundColor = "#F6F6F2"
                            arrowdownBtn.style.backgroundColor = "#FAB3A9";
                            getPosts(1)
                        }
                    });
            })


            // comments

            const comments = document.createElement("div");
            comments.classList.add("comments");

            postAndComments.appendChild(comments);

            const commentBar = document.createElement("div");
            commentBar.classList.add("commentBar");

            comments.appendChild(commentBar);

            const commentInput = document.createElement("input");
            commentInput.classList.add("commentInput");
            commentInput.type = "text";
            commentInput.placeholder = "Comment something...";

            commentBar.appendChild(commentInput);

            const makeComment = document.createElement("i");
            makeComment.classList.add("fa-solid", "fa-circle-chevron-right");

            commentBar.appendChild(makeComment);

            const ul = document.createElement("ul");

            comments.appendChild(ul);

            makeComment.addEventListener("click", function(){
                // /comments/create/{postid}/{comment}/{userid}
                var comment = commentInput.value;

                console.log(x+1);
                console.log(comment);
                console.log(userid);

                if (comment != ""){
                    fetch(`http://localhost:8000/api/comments/create/${x+1}/${comment}/${userid}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then((data) => {
                            console.log(data);
                    });
                }
                else{
                    alert("comment something");
                }
            })

            // fetch comments

            fetch(`http://localhost:8000/api/comments/${x+1}/${pagenumber}`)
            .then(response => response.json())
            .then(data => {

                for (let y = 0; y < data.length; y++){
                    //for each comment
                    console.log(data[y]);

                    const li = document.createElement("li")

                    ul.appendChild(li);

                    const commentVotes = document.createElement("div");
                    commentVotes.classList.add("votes");

                    li.appendChild(commentVotes);


                    const commentarrowupBtn = document.createElement("button");
                    commentarrowupBtn.classList.add("arrowupBtn", "arrowBtn");
        
                    const commentarrowup = document.createElement("i");
                    commentarrowup.classList.add("fa-solid", "fa-circle-arrow-up");
        
                    const commentnumVotes = document.createElement("h2");
                    commentnumVotes.innerHTML = data[y].votes
                    //commentvotes.id = numVotes
        
                    const commentarrowdownBtn = document.createElement("button");
                    commentarrowdownBtn.classList.add("arrowdownBtn", "arrowBtn");
        
                    const commentarrowdown = document.createElement("i");
                    commentarrowdown.classList.add("fa-solid", "fa-circle-arrow-down"); 
        
                    commentarrowupBtn.appendChild(commentarrowup);
                    commentVotes.appendChild(commentarrowupBtn);
                    commentVotes.appendChild(commentnumVotes);
                    commentarrowdownBtn.appendChild(commentarrowdown);
                    commentVotes.appendChild(commentarrowdownBtn);

                    const comment = document.createElement("div");
                    comment.classList.add("comment");

                    li.appendChild(comment);

                    const commentProfile = document.createElement("div");
                    commentProfile.classList.add("profile");

                    comment.appendChild(commentProfile);

                    const commentProfilePic = document.createElement("img");
                    commentProfilePic.src = "./images/607426-200.png"; ///////// change
                    commentProfilePic.id = "profilePic";

                    commentProfile.appendChild(commentProfilePic);

                    const commentUsername = document.createElement("h2");
                    commentUsername.id = "username";
                    commentUsername.innerHTML = data[y].username

                    commentProfile.appendChild(commentUsername);

                    const commentDate = document.createElement("p");
                    commentDate.innerHTML = data[y].created_at;
                    commentDate.id = "commentDate";

                    commentProfile.appendChild(commentDate);

                    const commentText = document.createElement("p");
                    commentText.classList.add("commentText");
                    commentText.innerHTML = data[y].comment;

                    comment.appendChild(commentText);

                    commentbtnEl.innerHTML = `Tails: ${data.length}`;

                    if(data[y].voted == "upvote"){
                        commentarrowupBtn.style.backgroundColor = "#FAB3A9";
                    }
        
                    if(data[y].voted == "downvoted"){
                        commentarrowdownBtn.style.backgroundColor = "#FAB3A9";
                    }
        
                    var userid = window.localStorage.getItem("userid");

                    commentarrowupBtn.addEventListener("click", function(){

                        // /interactions/upvotecomment/{commentid}/{userid}
                        fetch(`http://localhost:8000/api/interactions/upvotecomment/${y+1}/${userid}`, { 
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            console.log(data);
        
                            if (data.upvoted == true){
                                commentarrowdownBtn.style.backgroundColor = "#F6F6F2"
                                commentarrowupBtn.style.backgroundColor = "#FAB3A9";
                                getPosts(1);
                            }
                        });
                    })
        
                    commentarrowdownBtn.addEventListener("click", function(){
        
                        // /interactions/downvotecomment/{commentid}/{userid}
                        fetch(`http://localhost:8000/api/interactions/downvotecomment/${y+1}/${userid}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then((data) => {
                            console.log(data);
    
                            if (data.downvote == true){
                                commentarrowupBtn.style.backgroundColor = "#F6F6F2"
                                commentarrowdownBtn.style.backgroundColor = "#FAB3A9";
                                getPosts(1)
                            }
                        });
                    })

                }

                // if data.length > (what number is a page of comments (ewa))
                var seeMore = document.createElement("button");
                seeMore.classList.add("seeMore");
                seeMore.innerHTML = "see more..."

                comments.appendChild(seeMore);
            });
        }

        //display comments on button click

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


        // going to profile

            var profilePics = document.querySelectorAll(".postProfilePic");
            var usernames = document.querySelectorAll(".postUsername");

            for (let y = 0; y < profilePics.length; y++){
                profilePics[y].addEventListener("click", function(){
                    if (usernames[y].innerHTML == window.localStorage.getItem("username"))
                    {
                        window.location.href = "profile.html";
                        window.localStorage.setItem("personal", true);
                        window.localStorage.setItem("usernameToGet", usernames[y].innerHTML)
                    }
                    else{
                        window.location.href = "profile.html";
                        window.localStorage.setItem("personal", false);
                        window.localStorage.setItem("usernameToGet", usernames[y].innerHTML)
                    }
                })
            }
    }
}
