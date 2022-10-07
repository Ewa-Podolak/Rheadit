<?php

use App\Http\Controllers\commentController;
use App\Http\Controllers\followerController;
use App\Http\Controllers\interactionController;
use App\Http\Controllers\postController;
use App\Http\Controllers\userController;
use App\Http\Controllers\communityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//User Routes
Route::get('/users/login/{username}/{pasword}', [userController::class, 'CheckLogin']); //Checks Login Credentials //Works

Route::post('/users/register/{username}/{pasword}/{email}', [userController::class, 'RegisterUser']); //Creates new user if user with same username doesn't exist yet //Works

//Sent in body
Route::patch('/users/profilepicture/{userid}', [userController::class, 'UpdatePicture']); //Allows user to change their profile picture //works

//Sent in body
Route::patch('/users/bio/{userid}', [userController::class, 'UpdateBio']); //Allows user to change their bio //works

Route::get('/users/sendemail', [userController::class, 'SendEmail']); //Sends email for resetting password //welp ///////// fe not done

Route::patch('/users/resetpassword/{userid}', [userController::class, 'ResetPassword']); //Updates password //welp ///////// fe not done
//Send password in body of api call

Route::delete('/users/delete/{userid}', [userController::class, 'DeleteUser']); //Allows user to delete their account //works

Route::get('/users/{userid}/{username}', [userController::class, 'GetProfile']); //Returns username, bio, profilpic, number of followers, followed/following //works
//userid is logged in person, username is the person they want to follow



//Posts Routes //All works
Route::get('/posts/{postid}/{userid}', [postController::class, 'ReturnPost']); //Gets Post

Route::get('/posts/homepage/{pagenumber}/{userid}', [postController::class, 'GetHomepagePosts']); //Returns the newest posts for Homepage

Route::get('/posts/explorehomepage/{pagenumber}/{userid}', [postController::class, 'GetExploreHomePage']); //Returns the newest posts for Explore Homepage   ////// fe what to do

Route::get('/posts/userposts/newest/{userid}/{page}', [postController::class, 'GetUserNewestPosts']); //Returns the most recenet posts of the user

Route::get('/posts/userposts/liked/{userid}/{page}', [postController::class, 'GetUserLikedPosts']); //Returns the most liked posts of the user

Route::get('/posts/{community}/newest/{userid}/{page}', [postController::class, 'GetCommunityNewestPosts']); //Returns the newest posts for a community

Route::get('/posts/{community}/liked/{userid}/{page}', [postController::class, 'GetCommunityLikedPOsts']); //Returns the most liked posts for a community

Route::post('/posts/{community}/create/{userid}', [postController::class, 'PostInCommunity']); //Allows user to create post

Route::delete('/posts/delete/{postid}/{userid}', [postController::class, 'DeletePost']); //Allows user or mod/owner to delete a pst




//Comments Routes //All works
Route::get('/comments/{postid}/{page}/{userid}', [commentController::class, 'GetComments']); //Returns all comments of post, with their likes/dislikes
//and whether they are favourited by the creater

Route::patch('/comments/favourite/{postid}/{commentid}/{userid}', [commentController::class, 'FavouriteComment']); //Allows owner of post to favoruite comment ////////// fe not done

Route::post('/comments/create/{postid}/{userid}', [commentController::class, 'CreateComment']); //Allows user to create comment

Route::delete('/comments/delete/{commentid}/{userid}', [commentController::class, 'DeleteComment']); //Allows user or mod/owner to delete a comment



//Interaction Routes //All works
Route::post('/interactions/upvotepost/{postid}/{userid}', [interactionController::class, 'UpvotePost']); //Allows user to like post

Route::post('/interactions/downvotepost/{postid}/{userid}', [interactionController::class, 'DownvotePost']); //Allows user to dislike post

Route::post('/interactions/upvotecomment/{commentid}/{userid}', [interactionController::class, 'Upvotecomment']); //Allows user to upvote commment

Route::post('/interactions/downvotecomment/{commentid}/{userid}', [interactionController::class, 'DownvoteComment']); //Allows user to downvote comment



//Followers Routes //All works
Route::get('/followers/list/followers/{username}', [followerController::class, 'GetFollowersList']); //Returns list of all usernames of followers

Route::get('/followers/list/followed/{username}', [followerController::class, 'GetFollowedList']); //Returns list of all usernames of followed/following

Route::get('/followers/follow/{userid}/{username}', [followerController::class, 'Follow']); //Returns list of all usernames of followed/following
//userid is logged in user, usernme is username of person they want to follow


//Community //All works
Route::post('/community/{communityname}/join/{userid}', [communityController::class, 'JoinCommunity']); //Allows user to join community

Route::delete('/community/{communityname}/leave/{userid}', [communityController::class, 'LeaveCommunity']); //Allows user to leave

Route::patch('/community/{communityname}/transferownership/{userid}/{newonwerid}', [communityController::class, 'TransferOwnership']); //Allows for community ownership transfer //// fe not used

Route::delete('/community/delete/{communityname}/{userid}', [communityController::class, 'DeleteCommunity']); //Allows owner to delete a community

Route::get('/community/getinfo/{communityname}/{userid}', [communityController::class, 'GetCommunity']); //returns community information

Route::patch('/community/requestmod/{communityname}/{userid}', [communityController::class, 'RequestMod']); //returns community information ///// fe not used

Route::patch('/community/approvemod/{communityname}/{userid}/{username}', [communityController::class, 'ApproveMod']); //returns community information ///// fe not used
//userid is currently logged in oerson, username is the person they want to approve

Route::patch('/community/updatebio/{communityname}/{userid}', [communityController::class, 'UpdateCommunityBio']); //returns community information

Route::patch('/community/updateprofilepic/{communityname}/{userid}', [communityController::class, 'UpdateCommunityPic']); //returns community information

Route::get('/community/notification/{userid}', [communityController::class, 'OwnerRequestNotifications']); //returns community information  //// fe not used

Route::get('/community/joinable/{userid}', [communityController::class, 'JoinableComunity']); //Returns the list of all joinable communities //notworking yet