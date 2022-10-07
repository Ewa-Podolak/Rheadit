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
          })
    })
}

if (!window.location.href.includes("index.html")){

    var pagenumber = 1;
    var commentpagenumber = 1;
    var postsContainer = document.querySelector(".postsContainer");
    var goToOwnProfileBtn = document.getElementById("goProfile");
    var userid = window.localStorage.getItem("userid");

    setupGeneralPage();

    if (!window.location.href.includes("post.html")){
        operatePages();
    }

    if (window.location.href.includes("home.html")){
        getPosts(pagenumber, null);
        newpost("home");
    }

    if(window.location.href.includes("profile")){
        newpost("home");
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
        var groupPic = document.getElementById("groupProfilePic");

        getPosts(pagenumber, groupname);
            
        var showgroupbio = document.getElementById("groupbioText");
        var numgroupmembers = document.getElementById("numgroupmembers");

        setupgroupPage();
        jointheGroup();
    }








    if (window.location.href.includes("post.html")){

        var postids = window.localStorage.getItem("postid");
        console.log(postids);
        var userid = window.localStorage.getItem("userid");

        var postsContainer = document.querySelector(".postpostsContainer");
        console.log(postsContainer);

        // /posts/{postid}/{userid}
        fetch(`http://localhost:8000/api/posts/${postids}/${userid}`)
        .then(response => response.json())
        .then(data => { 

            console.log(data);

            postsContainer.innerHTML = "";
            const postAndComments = document.createElement("div");
            postAndComments.classList.add("postAndComments");
            
            postsContainer.appendChild(postAndComments);
            
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
            numVotes.innerHTML = data.votes
    
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
            
            if (data.profilepic != null){
                profilePic.src = data.profilepic;
            }

            const usernameEl = document.createElement("h2");
            usernameEl.id = "username";
            usernameEl.classList.add("postUsername");
            usernameEl.innerHTML = data.username
    
            const groupname = document.createElement("h2");
            groupname.id = "groupname";
            groupname.innerHTML = data.community; 
    
            const deletepostbtn = document.createElement("button");
            deletepostbtn.classList.add("deletepost", "fa-solid", "fa-eraser");
    
            profile.appendChild(profilePic);
            profile.appendChild(usernameEl);
            profile.appendChild(groupname);
            profile.appendChild(deletepostbtn);
    
            const postImgTxt = document.createElement("div");
            postImgTxt.classList.add("postImgTxt");
            
            thePost.appendChild(postImgTxt);
    
            const HeadtextEl = document.createElement("h2");
            HeadtextEl.id = "text" 
            HeadtextEl.innerHTML = data.head; 
    
            const BodytextEl = document.createElement("h3");
            BodytextEl.id = "body" 
            BodytextEl.innerHTML = data.body; 
    
            if (data.picture != null){
                const postImg = document.createElement("img"); 
                postImg.src = data.picture 
                postImgTxt.appendChild(postImg); 
            }

            postImgTxt.appendChild(HeadtextEl);
            postImgTxt.appendChild(BodytextEl);
    
                    
            if(data.voted == "upvote"){
                arrowupBtn.style.backgroundColor = "#FAB3A9";
            }
    
            if(data.voted == "downvoted"){
                arrowdownBtn.style.backgroundColor = "#FAB3A9";
            }

            var userid = window.localStorage.getItem("userid");

            deletepostbtn.addEventListener("click", ()=>{
                console.log("normal delete button");
                console.log(postarray[x])
    
                fetch(`http://localhost:8000/api/posts/delete/${postids}/${userid}`, { 
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
    
                    if (data.Deleted == false){
                        console.log("cannot delete");
                    }
                    else{
                        postAndComments.removeChild(post);
                    }
                });
            })

            groupname.addEventListener("click", function(){
                window.location.href = "group.html";
                window.localStorage.setItem("groupname", groupname.innerHTML)
            })

            arrowupBtn.addEventListener("click", function(){

                fetch(`http://localhost:8000/api/interactions/upvotepost/${postids}/${userid}`, { 
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
                        window.location.href = "post.html";
                    }
                });
            })
            
            arrowdownBtn.addEventListener("click", function(){
    
                fetch(`http://localhost:8000/api/interactions/downvotepost/${postids}/${userid}`, {
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
                        window.location.href = "post.html";
                    }
                });
            })


            const comments = document.createElement("div");
            comments.classList.add("comments");
            comments.style.display = "block";
    
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

            makeComment.addEventListener("click", function(){ //////// sets for every comment // get out of loop // should really change
                console.log("make comment");
                var commentmade = commentInput.value;
    
                if (commentmade != ""){
                    console.log(commentmade)
                    var data = {comment: commentmade}
                    fetch(`http://localhost:8000/api/comments/create/${postids}/${userid}`, { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => response.json())
                    .then((data) => {
                            console.log(data);
                            window.location.href = "post.html"
                    });
                }
                else{
                    alert("comment something");
                }
            })

            getpostcomments();

            function getpostcomments(){
                fetch(`http://localhost:8000/api/comments/${postids}/${commentpagenumber}/${userid}`)
                .then(response => response.json())
                .then(data => {

                    for (let y = 0; y < data.length; y++){
                        
                        const li = document.createElement("li")

                        ul.appendChild(li);

                        const commentVotes = document.createElement("div");
                        commentVotes.classList.add("votes");

                        li.appendChild(commentVotes);


                        const commentarrowupBtn = document.createElement("button");
                        commentarrowupBtn.classList.add("arrowupBtn", "arrowBtn");
                        commentarrowupBtn.id = "upvotecom";

                        cbtns = document.querySelectorAll("#upvotecom");
            
                        const commentarrowup = document.createElement("i");
                        commentarrowup.classList.add("fa-solid", "fa-circle-arrow-up");
            
                        const commentnumVotes = document.createElement("h2");
                        commentnumVotes.innerHTML = data[y].votes
            
                        const commentarrowdownBtn = document.createElement("button");
                        commentarrowdownBtn.classList.add("arrowdownBtn", "arrowBtn");
                        commentarrowdownBtn.id = "downvotcom";
            
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
            
                        const deletecommentBtn = document.createElement("button");
                        deletecommentBtn.classList.add("deletecomment", "fa-solid", "fa-eraser");

                        comment.appendChild(deletecommentBtn);

                        // deletecommentBtn.addEventListener("click", ()=>{
                        //     fetch(`http://localhost:8000/api/comments/delete/${commentarray[x]}/${userid}`, { /// comment id doesnt work
                        //         method: 'DELETE',
                        //         headers: {
                        //             'Content-Type': 'application/json',
                        //         },
                        //     })
                        //     .then((response) => response.json())
                        //     .then((data) => {
                        //         console.log(data);
                
                        //         if (data.Deleted == false){
                        //             console.log("cannot delete");
                        //         }
                        //         else{
                        //             postAndComments.removeChild(post);
                        //         }
                        //     });

                        // })

                    }

                    var seeMore = document.createElement("button");
                    seeMore.classList.add("seeMore");
                    seeMore.innerHTML = "see more..."

                    comments.appendChild(seeMore);

                    seeMore.addEventListener("click", ()=>{
                        commentpagenumber++;
                        comments.removeChild(seeMore);
                        getpostcomments();
                        
                    })

                });
            }

        });
        
    }
}

function follow(username){
    var followBtn = document.getElementById("followBtn");
    followBtn.addEventListener("click", ()=>{
        followBtn.innerHTML = "Unfollow";
        
        fetch(`http://localhost:8000/api/followers/follow/${userid}/${username}`)
        .then(response => response.json())
        .then(data => {
            window.location.href = "profile.html";
            window.localStorage.setItem("personal", false);
            window.localStorage.setItem("usernameToGet", username)
        });
    })
}

function jointheGroup(){
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
            });
        })
}

function leave(leavegroup, communityname){
    leavegroup.addEventListener("click", ()=>{
        fetch(`http://localhost:8000/api/community/${communityname}/leave/${userid}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then((response) => response.json())
        .then((data) => {
                window.location.href = "home.html";
        });
    })
}

function setupgroupPage(){
    fetch(`http://localhost:8000/api/community/getinfo/${groupname}/${userid}`)
        .then(response => response.json())
        .then(data => {

            var leavegroup = document.getElementById("leavegroup");
            leave(leavegroup, data.communityname);

            if(data.userrole != null){
                newpost(groupname);
            }
            else{
                var createnewPost = document.querySelector(".createnewPost")
                var newposttxt = document.querySelector(".newposttxt")
                createnewPost.id = "grey";
                newposttxt.disabled = true;
                leavegroup.style.display = "none";
            }

            showgroupname.innerHTML = data.communityname;
            showgroupbio.innerHTML = data.bio
            numgroupmembers.innerHTML = data.memebernumber;
            if(data.profilepic == null){
                groupPic.src = "./images/607426-200.png";
            }
            else{
                groupPic.src = data.profilepic;
            }

            if (data.userrole == null){
                joinGroup.innerHTML = "join"
                joinGroup.disabled = false;

            }
            else{
                joinGroup.innerHTML = data.userrole;
            }

            if (joinGroup.innerHTML == "owner"){
                leavegroup.style.display = "none";
                ownerpriviledges(data.communityname);
            }

            if (joinGroup.innerHTML == "mod"){
                console.log("mod")
            }
        });
}

function ownerpriviledges(communityname){
    var editgroupProfile = document.getElementById("groupeditProfile");
    var groupeditBio = document.getElementById("groupeditBio");
    
    editgroupProfile.style.display = "block";
    groupeditBio.style.display = "block";

    newgroupbio(communityname);
    newgroupprofile(editgroupProfile, communityname);
    deletegroup(communityname);
}

function deletegroup(communityname){
    var deletegroup = document.getElementById("deletegroup");
    deletegroup.style.display = "block";
    deletegroup.addEventListener("click", ()=>{
        userid = window.localStorage.getItem("userid");

        fetch(`http://localhost:8000/api/community/delete/${communityname}/${userid}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then((response) => response.json())
        .then((data) => {
                window.location.href = "home.html";
        });
    })
}

function newgroupprofile(editgroupProfile, communityname){
    editgroupProfile.addEventListener("click", function(){
        var profilePicEditorContainer = document.querySelector(".profilePicEditorContainer");
        profilePicEditorContainer.style.display = "flex"
        var close = document.querySelector(".close");
        var submitNewProfilePic = document.querySelector("#submitNewProfilePic");
        var submitNewProfilePicBox = document.getElementById("submitNewProfilePicBox");
        var newProfilePic = document.querySelector(".grouppagePic");

        close.addEventListener("click", function(){
            profilePicEditorContainer.style.display = "none"
        })

        submitNewProfilePic.addEventListener("click", function(){ 

            var data = { profilepic: submitNewProfilePicBox.value};
            var userid = window.localStorage.getItem("userid");

            fetch(`http://localhost:8000/api/community/updateprofilepic/${communityname}/${userid}`, { 
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then((response) => response.json())
            .then((data) => {
                profilePicEditorContainer.style.display = "none"     
            });

            newProfilePic.src = submitNewProfilePicBox.value;

        })
    })
}

function newgroupbio(communityname){
    var groupbioText = document.getElementById("groupbioText");
    var newBio = document.getElementById("newBio");
    var newBioBtn = document.getElementById("newBioBtn");

    groupeditBio.addEventListener("click", ()=> {
        newBio.style.display = "block";
        newBioBtn.style.display = "block";

        newBioBtn.addEventListener("click", function(){
            groupbioText.innerHTML = newBio.value;
            var data = { bio: newBio.value};
            newBio.style.display = "none";
            newBioBtn.style.display = "none";

            fetch(`http://localhost:8000/api/community/updatebio/${communityname}/${userid}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then((response) => response.json())
            .then((data) => {
            });
        })
    })
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
            var data = { bio: newBio.value};

            newBio.style.display = "none";
            newBioBtn.style.display = "none";
            fetch(`http://localhost:8000/api/users/bio/${window.localStorage.getItem("userid")}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then((response) => response.json())
            .then((data) => {
            });
        })
    })
}

function deleteuser(){
    var deleteuser = document.getElementById("deleteuser");
    deleteuser.style.display = "block";
    deleteuser.addEventListener("click", ()=>{
        userid = window.localStorage.getItem("userid");
        fetch(`http://localhost:8000/api/users/delete/${userid}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then((response) => response.json())
        .then((data) => {
                window.location.href = "index.html";
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

    follow(usernameProfile);

    fetch(`http://localhost:8000/api/users/${loggedinUsername}/${usernameProfile}`)
    .then(response => response.json())
    .then(data => {

        usernameText.innerHTML = usernameProfile;
        bioText.innerHTML = data.bio;
        followers.innerHTML = data.followers;
        following.innerHTML = data.following;

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

    checkiffollowing(usernameProfile);
    getfollowers(followersOrFollowingListContainer, usernameProfile, boxContents);
    getfollowing(followersOrFollowingListContainer, usernameProfile, boxContents);
    
}

function checkiffollowing(usernameProfile){
    fetch(`http://localhost:8000/api/followers/list/followers/${usernameProfile}`) 
    .then(response => response.json())
    .then(data => {

        if (data.length > 0){
            for (let x = 0; x < data.length; x++){
                var followBtn = document.getElementById("followBtn");
                var loggedin = window.localStorage.getItem("username")
                if (data[x].username == loggedin){
                    followBtn.innerHTML = "Unfollow";
                }
            }
        }
    });
}

function getfollowing(followersOrFollowingListContainer, usernameProfile, boxContents){

    var followingBtn = document.querySelector(".following");
    followingBtn.addEventListener("click", function(){
        followersOrFollowingListContainer.style.display = "flex";

        fetch(`http://localhost:8000/api/followers/list/followed/${usernameProfile}`) 
        .then(response => response.json())
        .then(data => {

            if (data.length > 0){
                boxContents.innerHTML = "Following: "
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

        fetch(`http://localhost:8000/api/followers/list/followers/${usernameProfile}`) 
        .then(response => response.json())
        .then(data => {

            if (data.length > 0){
                boxContents.innerHTML = "Followers: "
                for (let x = 0; x < data.length; x++){
                    boxContents.innerHTML += `<br>`;
                    boxContents.innerHTML += data[x].username;
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
        getPosts(1, null);
    })
    mostPopular.addEventListener("click", function(){
        recent = false;
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
    fetch(`http://localhost:8000/api/posts/${groupname}/liked/${userid}/${pagenumber}`) 
    .then(response => response.json())
    .then(data => {
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
    fetch(`http://localhost:8000/api/posts/${groupname}/newest/${userid}/${pagenumber}`) 
    .then(response => response.json())
    .then(data => {
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
    fetch(`http://localhost:8000/api/posts/userposts/newest/${userid}/${pagenumber}`)
    .then(response => response.json())
    .then(data => {

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
    var postarray = [];
    var commentarray = [];
    var commentcounter = 0;

    postsContainer.innerHTML = "";
    for (let x = 0; x < data.length; x++){

        postarray.push(data[x].postid)

        const postAndComments = document.createElement("div");
        postAndComments.classList.add("postAndComments");

        postsContainer.appendChild(postAndComments);

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
     
        if (data[x].profilepic != null){
            profilePic.src = data[x].profilepic;
        }

        const usernameEl = document.createElement("h2");
        usernameEl.id = "username";
        usernameEl.classList.add("postUsername");
        usernameEl.innerHTML = data[x].username

        const groupname = document.createElement("h2");
        groupname.id = "groupname";
        groupname.innerHTML = data[x].community; 

        const deletepostbtn = document.createElement("button");
        deletepostbtn.classList.add("deletepost", "fa-solid", "fa-eraser");

        profile.appendChild(profilePic);
        profile.appendChild(usernameEl);
        profile.appendChild(groupname);
        profile.appendChild(deletepostbtn);

        const postImgTxt = document.createElement("div");
        postImgTxt.classList.add("postImgTxt");

        thePost.appendChild(postImgTxt);

        const HeadtextEl = document.createElement("h2");
        HeadtextEl.id = "text" 
        HeadtextEl.innerHTML = data[x].head; 

        const BodytextEl = document.createElement("h3");
        BodytextEl.id = "body" 
        BodytextEl.innerHTML = data[x].body; 

        if (data[x].picture != null){
            const postImg = document.createElement("img"); 
            postImg.src = data[x].picture 
            postImgTxt.appendChild(postImg); 
        }

        postImgTxt.appendChild(HeadtextEl);
        postImgTxt.appendChild(BodytextEl);

        const interactions = document.createElement("div");
        interactions.classList.add("interactions");

        thePost.appendChild(interactions);

        const commentbtnEl = document.createElement("button");
        commentbtnEl.classList.add("commentbtn");
        commentbtnEl.innerHTML = "Tails: 0";

        interactions.appendChild(commentbtnEl);

        commentbtnEl.addEventListener("click", ()=>{
            window.localStorage.setItem("postid", postarray[x])
            window.location.href = "post.html";
        })

        if(data[x].voted == "upvote"){
            arrowupBtn.style.backgroundColor = "#FAB3A9";
        }

        if(data[x].voted == "downvoted"){
            arrowdownBtn.style.backgroundColor = "#FAB3A9";
        }

        var userid = window.localStorage.getItem("userid");

        deletepostbtn.addEventListener("click", ()=>{
            console.log("normal delete button");
            // /posts/delete/{postid}/{userid}
            console.log(postarray[x])

            fetch(`http://localhost:8000/api/posts/delete/${postarray[x]}/${userid}`, { 
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);

                if (data.Deleted == false){
                    console.log("cannot delete");
                }
                else{
                    postAndComments.removeChild(post);
                }
            });
        })

        groupname.addEventListener("click", function(){
            window.location.href = "group.html";
            window.localStorage.setItem("groupname", groupname.innerHTML)
        })

        arrowupBtn.addEventListener("click", function(){

            fetch(`http://localhost:8000/api/interactions/upvotepost/${postarray[x]}/${userid}`, { 
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

                fetch(`http://localhost:8000/api/interactions/downvotepost/${postarray[x]}/${userid}`, {
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

    }

    //cbtns = document.querySelectorAll("#upvotecom");

    // console.log("commentarrowupbtns: " + cbtns)
    // console.log("number of comments: " + cbtns.length);

    //////////////////////////////////////
    // var cbtns = document.querySelectorAll("#upvotecom");
    // console.log("commentarrowupbtns: " + cbtns)
    // console.log("number of comments: " + cbtns.length);

    // commentarrowupBtn.addEventListener("click", function(){

    //     console.log("arrowup for comment no.: " + commentarray[commentarrowup])

    //     fetch(`http://localhost:8000/api/interactions/upvotecomment/${}/${userid}`, { // commentarray[y] is 0, 1 and then 0
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //         },
    //     })
    //     .then((response) => response.json())
    //     .then((data) => {

    //         if (data.upvoted == true){
    //             commentarrowdownBtn.style.backgroundColor = "#F6F6F2"
    //             commentarrowupBtn.style.backgroundColor = "#FAB3A9";
    //             // console.log("vote num")
    //             // console.log((data[y]))
    //             // commentnumVotes.innerHTML = (parseInt(data[y].votes) + 1)
    //         }
    //     });
    // })

    // commentarrowdownBtn.addEventListener("click", function(){

    //     console.log("arrowup for comment no.: " + commentarray[commentarrowup])

    //     fetch(`http://localhost:8000/api/interactions/downvotecomment/${}/${userid}`, {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //         },
    //     })
    //     .then(response => response.json())
    //     .then((data) => {
    //         console.log(data);

    //         if (data.downvote == true){
    //             commentarrowupBtn.style.backgroundColor = "#F6F6F2"
    //             commentarrowdownBtn.style.backgroundColor = "#FAB3A9";
    //             commentnumVotes.innerHTML = (parseInt(data[y].votes) -1)
    //         }
    //     });
    // })

    /////////////////////////////////////




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
    gotoHome();
    logout();
    togglemenu();
}

function setdropdownUsername(){
    var dropdownusername = window.localStorage.getItem("username");
    var dropUsername = document.querySelector(".dropUsername");
    dropUsername.innerHTML = dropdownusername;
}

function newpost(group){
    var newpostbtn = document.querySelector(".newpostbtn");
    var newposttxt = document.querySelector(".newposttxt");
    var secondbox = document.querySelector(".secondbox");
    var newbodytxt = document.querySelector(".newbodytxt");
    var imgbtn = document.querySelector(".imgbtn");
    var thirdbox = document.querySelector(".thirdbox")
    var newbodyimg = document.querySelector(".newbodyimg");

    imgbtn.addEventListener("click", ()=>{
        thirdbox.style.display = "flex";
    })

    newposttxt.addEventListener("click", ()=>{
        secondbox.style.display = "flex";
    })
    
    newpostbtn.addEventListener("click", ()=>{
        secondbox.style.display = "none";
        thirdbox.style.display = "none";
        console.log(newposttxt.value == "");

        if (newposttxt.value != ""){
            data = {head: newposttxt.value, body: newbodytxt.value, picture: newbodyimg.value};

            fetch(`http://localhost:8000/api/posts/${group}/create/${userid}`, {
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
        }
        else{
            alert("enter a title")
        }

    })
}

function goToOwnProfile(){
    goToOwnProfileBtn.addEventListener("click", function(){
        var dropUser = document.querySelector(".dropUsername");
        window.location.href = "profile.html";
        window.localStorage.setItem("personal", true);
        window.localStorage.setItem("usernameToGet", dropUser.innerHTML);
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