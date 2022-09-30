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

Route::patch('/users/profilepicture/{userid}/{linktopicture}', [userController::class, 'UpdatePicture']); //Allows user to change their profile picture //no workey

Route::patch('/users/bio/{userid}/{bio}', [userController::class, 'UpdateBio']); //Allows user to change their bio //works

Route::get('/users/sendemail/{email}', [userController::class, 'SendEmail']); //Sends email for resetting password //welp

Route::patch('/users/resetpassword/{username}/{password}', [userController::class, 'ResetPassword']); //Updates password //welp

Route::delete('/users/delete/{userid}', [userController::class, 'DeleteUser']); //Allows user to delete their account //works

Route::get('/users/{userid}/{username}', [userController::class, 'GetProfile']); //Returns username, bio, profilpic, number of followers, followed/following //works



//Posts Routes
Route::get('/posts/homepage/{pagenumber}/{userid}', [postController::class, 'GetHomepagePosts']); //Returns the newest posts for Homepage //Works

Route::get('/posts/userposts/newest/{userid}/{page}', [postController::class, 'GetUserNewestPosts']); //Returns the most recenet posts of the user //works

Route::get('/posts/userposts/liked/{userid}/{page}', [postController::class, 'GetUserLikedPosts']); //Returns the most liked posts of the user //works

Route::get('/posts/{community}/newest/{userid}/{page}', [postController::class, 'GetCommunityNewestPosts']); //Returns the newest posts for a community //works

Route::get('/posts/{community}/liked/{userid}/{page}', [postController::class, 'GetCommunityLikedPOsts']); //Returns the most liked posts for a community //works

Route::post('/posts/{community}/create/{userid}', [postController::class, 'PostInCommunity']); //User creates post //welp

Route::delete('/posts/delete/{postid}/{userid}', [postController::class, 'DeletePost']); //Deletes post //works



//Comments Routes //All works
Route::get('/comments/{postid}/{page}/{userid}', [commentController::class, 'GetComments']); //Returns all comments of post, with their likes/dislikes
//and whether they are favourited by the creater

Route::patch('/comments/favourite/{postid}/{commentid}/{userid}', [commentController::class, 'FavouriteComment']); //Allows owner of post to favoruite comment

Route::post('/comments/create/{postid}/{comment}/{userid}', [commentController::class, 'CreateComment']); //Allows user to create comment

Route::delete('/comments/delete/{commentid}/{userid}', [commentController::class, 'GetComments']); //Allows user to delete a comment



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

Route::patch('/community/{communityname}/transferownership/{userid}/{newonwerid}', [communityController::class, 'TransferOwnership']); //Allows for community ownership transfer

Route::delete('/community/delete/{communityname}/{userid}', [communityController::class, 'DeleteCommunity']); //Allows owner to delete a community

Route::get('/community/getinfo/{communityname}/{userid}', [communityController::class, 'GetCommunity']); //returns community information
