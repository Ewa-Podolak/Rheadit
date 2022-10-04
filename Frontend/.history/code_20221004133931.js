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

        // '/users/sendemail'
        const data = { email: "email example" };

        fetch('https://example.com/profile', {
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        })
          .then((response) => response.json())
          .then((data) => {
            console.log(data);
          })
    })
}

if (!window.location.href.includes("index.html")){

    var pagenumber = 1;
    var postsContainer = document.querySelector(".postsContainer");
    var goToOwnProfileBtn = document.getElementById("goProfile");
    var userid = window.localStorage.getItem("userid");

    setupGeneralPage();

    if (window.location.href.includes("home.html")){
        getPosts(pagenumber, null);
        newpost();
    }

    if(window.location.href.includes("profile")){
        newpost();
        var recent = true;
        postSort();
        var personal = window.localStorage.getItem("personal");
        getPosts(pagenumber, null);
        setupgeneralProfile();

        if (personal == "true"){
            givePersonalControl();
        } 
    }

    if (window.location.href.includes("group.html")){
        
        var recent = true;
        postSort();

        var groupname = window.localStorage.getItem("groupname");
        var joinGroup = document.getElementById("joinGroup");
        var showgroupname = document.getElementById("groupUsername");

        getPosts(pagenumber, groupname);

        //if join innerhtml != join
        // newpost();

        if(joinGroup.innerHTML != "join"){
            newpost();
        }
        
        var showgroupbio = document.getElementById("groupBio");
        var numgroupmembers = document.getElementById("numgroupmembers");

        setupgroupPage();
        jointheGroup();
    }
}

function jointheGroup(){
    if (joinGroup.innerHTML == "join"){
        joinGroup.addEventListener("click", function(){
            joinGroup.innerHTML = "Requested";
            joinGroup.style.fontWeight = "700"

            fetch(`http://localhost:8000/api/community/${groupname}/join/${userid}`,{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            });
        })
    }
}

function setupgroupPage(){
    fetch(`http://localhost:8000/api/community/getinfo/${groupname}/${userid}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);

            showgroupname.innerHTML = data.communityname;
            showgroupbio.innerHTML = data.bio
            numgroupmembers.innerHTML = data.memebernumber;
            joinGroup.innerHTML = data.userrole;

            if (joinGroup.innerHTML == null){ /////////////// could change (depends what not already joined returns)
                joinGroup.innerHTML = "join";
                joinGroup.disabled = false;
            }

            // if joinGroup.innerHTML == owner 
            // show all options to change

            // if joinGroup.innerHTML == mod 
            // can delte posts
        });
}

function givePersonalControl(){
    var editBio = document.getElementById("editBio");
    var editProfile = document.getElementById("editProfile");
    var followBtn = document.getElementById("followBtn");

    followBtn.style.display = "none";
    editBio.style.display = "block";
    editProfile.style.display = "block";

    newbio();
    deleteuser();
    editprofilepic();
}

function editprofilepic(){
    editProfile.addEventListener("click", function(){
        var profilePicEditorContainer = document.querySelector(".profilePicEditorContainer");
        profilePicEditorContainer.style.display = "flex"
        var close = document.querySelector(".close");
        var submitNewProfilePic = document.querySelector("#submitNewProfilePic");
        var submitNewProfilePicBox = document.getElementById("submitNewProfilePicBox");
        var newProfilePic = document.querySelector(".profilepagePic");

        close.addEventListener("click", function(){
            profilePicEditorContainer.style.display = "none"
        })

        submitNewProfilePic.addEventListener("click", function(){ 

            var data = { profilepic: submitNewProfilePicBox.value};
            var userid = window.localStorage.getItem("userid");

            fetch(`http://localhost:8000/api/users/profilepicture/${userid}`, { 
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then((response) => response.json())
            .then((data) => {
                    console.log(data);

                    profilePicEditorContainer.style.display = "none"     
            });

            newProfilePic.src = submitNewProfilePicBox.value;

        })
    })
}

function newbio(){
    var newBio = document.getElementById("newBio");
    var newBioBtn = document.getElementById("newBioBtn");

    editBio.addEventListener("click", function(){
        newBio.style.display = "block";
        newBioBtn.style.display = "block";
        newBioBtn.addEventListener("click", function(){
            bioText.innerHTML = newBio.value;
            var data = { bio: newBio.value}; // change 

            fetch(`http://localhost:8000/api/users/bio/${window.localStorage.getItem("userid")}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then((response) => response.json())
            .then((data) => {
                    console.log(data);
            });
        })
    })
}

function deleteuser(){
    var deleteuser = document.getElementById("deleteuser");
    deleteuser.addEventListener("click", ()=>{
        userid = window.localStorage.getItem("userid");
        console.log(userid);
        console.log("delete");
        fetch(`http://localhost:8000/api/users/delete/${userid}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then((response) => response.json())
        .then((data) => {
                console.log(data);
                console.log("deleted");
        });
    })
}

function setupgeneralProfile(){

    var usernameProfile = window.localStorage.getItem("usernameToGet");
    var loggedinUsername = window.localStorage.getItem("username");

    var usernameText = document.getElementById("usernameText");
    var followers = document.getElementById("numOfFollowers");
    var following = document.getElementById("numOfFollowing");
    var bioText = document.getElementById("bioText");
    var profilePicture = document.querySelector(".profilepagePic");

    fetch(`http://localhost:8000/api/users/${usernameProfile}/${loggedinUsername}`)
    .then(response => response.json())
    .then(data => {
        console.log(data);

        usernameText.innerHTML = usernameProfile;
        bioText.innerHTML = data.bio;
        followers.innerHTML = data.followers;
        following.innerHTML = data.following;

        console.log(data.profilepic);
        if (!data.profilepic)
        {
            profilePicture.src = "./images/607426-200.png";
        }
        else{
            profilePicture.src = data.profilepic;
        }
    });

    var followersOrFollowingListContainer = document.querySelector(".followersOrFollowingListContainer");
    var boxContents = document.querySelector(".boxContents");

    getfollowers(followersOrFollowingListContainer, usernameProfile, boxContents);
    getfollowing(followersOrFollowingListContainer, usernameProfile, boxContents);
    
}

function getfollowing(followersOrFollowingListContainer, usernameProfile, boxContents){

    var followingBtn = document.querySelector(".following");
    followingBtn.addEventListener("click", function(){
        followersOrFollowingListContainer.style.display = "flex";

        fetch(`http://localhost:8000/api/followers/list/followed/${usernameProfile}`) 
        .then(response => response.json())
        .then(data => {
            console.log(data);

            if (data.length > 0){
                boxContents.innerHTML = "Following: "
                console.log(data[0].username)
                for (let x = 0; x < data.length; x++){
                    boxContents.innerHTML += `<br>`;
                    boxContents.innerHTML += data[0].username;
                }
            }
            else{
                boxContents.innerHTML = "Following: 0"
            }
        });

        var closeFollowing = document.querySelector("#closeBtn");
        closeFollowing.addEventListener("click", function(){
            followersOrFollowingListContainer.style.display = "none"
        })
    })
}

function getfollowers(followersOrFollowingListContainer, usernameProfile, boxContents){

    var followersBtn = document.querySelector(".followers");
    followersBtn.addEventListener("click", function(){
        followersOrFollowingListContainer.style.display = "flex";

        fetch(`http://localhost:8000/api/followers/list/followers/${usernameProfile}`) /////////// not giving anything
        .then(response => response.json())
        .then(data => {

            console.log("followers: "+ data);
            if (data.length > 0){
                boxContents.innerHTML = "Followers: "
                console.log(data[0].username)
                for (let x = 0; x < data.length; x++){
                    boxContents.innerHTML += `<br>`;
                    boxContents.innerHTML += data[0].username;
                }
            }
            else{
                boxContents.innerHTML = "Followers: 0"
            }
        });

        var closeFollowers = document.querySelector("#closeBtn");
        closeFollowers.addEventListener("click", function(){
            followersOrFollowingListContainer.style.display = "none"
        })
    })
}

function postSort(){
    var mostRecent = document.getElementById("mostRecent");
    var mostPopular = document.getElementById("mostPopular");
    mostRecent.addEventListener("click", function(){
        recent = true;
        console.log("recent");
        getPosts(1, null);
    })
    mostPopular.addEventListener("click", function(){
        recent = false;
        console.log("popular");
        getPosts(1, null);
    })
}

function getPosts(pagenumber, groupname){

    var userid = window.localStorage.getItem("userid");

    if(postsContainer.id == "homePage"){
        homepageposts();
    }
    else if (postsContainer.id == "profilePage"){
        if(recent){
            recentprofileposts();
        }
        else{
            popularprofileposts();
        }
    }
    else if (postsContainer.id == "groupPage"){
        if(recent){
            recentgroupposts();
        }
        else{
            populargroupposts();
        }
    }
}

function populargroupposts(){
    fetch(`http://localhost:8000/api/posts/${groupname}/liked/${userid}/${pagenumber}`) ///// community name not got
    .then(response => response.json())
    .then(data => {

        console.log(groupname);
        console.log(userid);
        console.log(pagenumber);
        console.log(data);

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

function recentgroupposts(){
    fetch(`http://localhost:8000/api/posts/${groupname}/newest/${userid}/${pagenumber}`) ///// community name not got
    .then(response => response.json())
    .then(data => {
        console.log(data);

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

function popularprofileposts(){
    fetch(`http://localhost:8000/api/posts/userposts/liked/${userid}/${pagenumber}`)
    .then(response => response.json())
    .then(data => {
        console.log(data);

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

function recentprofileposts(){
    console.log(userid)
            console.log(pagenumber)
            fetch(`http://localhost:8000/api/posts/userposts/newest/${userid}/${pagenumber}`)
            .then(response => response.json())
            .then(data => {
                
                console.log(data);

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

function homepageposts(){
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

        profilePic.src = "./images/607426-200.png";
     
        // if (data[x].profilepic.includes("http")){
        //     profilePic.src = data[x].profilepic;
        // }

        const usernameEl = document.createElement("h2");
        usernameEl.id = "username";
        usernameEl.classList.add("postUsername");
        usernameEl.innerHTML = data[x].username

        const groupname = document.createElement("h2");
        groupname.id = "groupname";
        groupname.innerHTML = data[x].community; 

        profile.appendChild(profilePic);
        profile.appendChild(usernameEl);
        profile.appendChild(groupname);

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

        groupname.addEventListener("click", function(){ /////////////////////////////////////////////////////////
            window.location.href = "group.html";
            window.localStorage.setItem("groupname", groupname.innerHTML)
        })

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

        var commentidarray = [];

        fetch(`http://localhost:8000/api/comments/${x+1}/${pagenumber}/${userid}`)
        .then(response => response.json())
        .then(data => {

            console.log(data);

            for (let y = 0; y < data.length; y++){
                //for each comment per post

                commentidarray.push(data[y].commentid);

                

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
                if (!commentProfilePic.src){
                    commentProfilePic.src = "./images/607426-200.png";
                }
                else{
                    commentProfilePic.src = data[y].profilepic;
                }

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

                    var commentid = commentidarray[y]; ///////// doesnt work
                    
                    console.log(commentid);


                    fetch(`http://localhost:8000/api/interactions/upvotecomment/${commentid}/${userid}`, { 
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
                    var commentid = commentidarray[y];

                    console.log(commentid)

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


function setupGeneralPage(){
    setdropdownUsername();
    goToOwnProfile();
    operatePages();
    gotoHome();
    logout();
    togglemenu();
}

function setdropdownUsername(){
    var dropdownusername = window.localStorage.getItem("username");
    var dropUsername = document.querySelector(".dropUsername");
    dropUsername.innerHTML = dropdownusername;
}

function newpost(){
    var newpostbtn = document.querySelector(".newpostbtn");
    var newposttxt = document.querySelector(".newposttxt");
    var secondbox = document.querySelector(".secondbox");
    var newbodytxt = document.querySelector(".newbodytxt");


    newposttxt.addEventListener("click", ()=>{
        secondbox.style.display = "flex";
    })
    
    newpostbtn.addEventListener("click", ()=>{
        secondbox.style.display = "none";
        console.log(newbodytxt.value);
        data = {head: newbodytxt.value, body: newposttxt.value, picture: null};

        fetch(`http://localhost:8000/api/posts/home/create/${userid}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then((response) => response.json())
        .then((data) => {
                console.log(data);
                getPosts(1);
        }); 
    })
}

function goToOwnProfile(){
    goToOwnProfileBtn.addEventListener("click", function(){
        window.location.href = "profile.html";
        window.localStorage.setItem("personal", true);
    })
}

function operatePages(){
    var plusPageNum = document.getElementById("plusPageNum");
    var minusPageNum = document.getElementById("minusPageNum");
    var pageNum = document.getElementById("pageNum");

    plusPageNum.addEventListener("click", function(){
        pagenumber++;
        pageNum.innerHTML = pagenumber
        getPosts(pagenumber, null);
    })

    minusPageNum.addEventListener("click", function(){
        if (pagenumber > 1){
            pagenumber--;
            pageNum.innerHTML = pagenumber
            getPosts(pagenumber, null);
        }
    })
}

function gotoHome(){
    var logo = document.getElementById("logo");
    logo.addEventListener("click", function(){
        window.location.href = "home.html";
    })
}

function logout(){
    var logoutBtn = document.getElementById("logout")
    logoutBtn.addEventListener("click", function(){
        window.location.href = "index.html"
    })
}

function togglemenu(){
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
}