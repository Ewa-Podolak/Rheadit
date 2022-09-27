<?php

use App\Http\Controllers\followerController;
use App\Http\Controllers\interactionController;
use App\Http\Controllers\postController;
use App\Http\Controllers\userController;
//use use App\Http\Controllers\communityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//User Routes


Route::get('/users/sendemail/{email}', [userController::class, 'SendEmail']); //Sends email for resetting password

Route::patch('/users/resetpassword/{username}/{password}', [userController::class, 'ResetPassword']); //Updates password

Route::delete('/users/delete/{userid}', [userController::class, 'DeleteUser']); //Allows user to delete their account //Working

Route::get('/users/{userid}', [userController::class, 'GetProfile']); //Returns username, number of followers, followed, posts, comments


//Posts Routes
Route::get('/posts/homepage/{pagenumber}', [postController::class, 'GetHomepagePosts']); //Returns the newest posts for Homepage

Route::get('/posts/userposts/newsest/{userid}', [postController::class, 'GetUserNewestPosts']); //Returns the most recenet posts of the user

Route::get('/posts/userposts/liked/{userid}', [postController::class, 'GetUserLikedPosts']); //Returns the most liked posts of the user

Route::get('/posts/{community}/newest', [postController::class, 'GetCommunityNewestPosts']); //Returns the newest posts for a community

Route::get('/posts/{community}/liked', [postController::class, 'GetCommunityLikedPOsts']); //Returns the most liked posts for a community

Route::patch('/posts/upvote/{postid}/{userid}', [postController::class, 'UpvotePost']); //Allows user to like post

Route::patch('/posts/downvote/{postid}/{userid}', [postController::class, 'DownvotePost']); //Allows user to dislike post

Route::post('/posts/{community}/create/{userid}', [postController::class, 'PostInCommunity']); //User creates post

Route::delete('/posts/delete/{postid}/{userid}', [postController::class, 'DeletePost']); //Deletes post

Route::get('/posts/{postid}', [postController::class, 'ReturnPost']); //Returns post with upvotes, first coment page and other information


//Comments Routes
Route::get('/commments/{postid}/{page}', [interactionController::class, 'GetComments']); //Returns all comments of post, with their likes/dislikes 
//and whether they are favourited by the creater
//Remember to discuss page numebr with Milllie!!!!!

Route::patch('/commments/upvote/{postid}/{userid}', [interactionController::class, 'Upvotecomment']); //Allows user to upvote 

Route::patch('/commments/downvote/{postid}/{userid}', [interactionController::class, 'GetComments']); //Allows user to downvote

Route::patch('/commments/favourite/{postid}/{userid}', [interactionController::class, 'FavouriteComment']); //Allows owner of post to favoruite comment 

Route::post('/commments/create/{postid}/{userid}', [interactionController::class, 'CreateComment']); //Allows user to create comment

Route::delete('/commments/delete/{postid}/{userid}', [interactionController::class, 'GetComments']); //Allows user to delete a comment

//Followers Routes
Route::get('/followers/list/followers/{userid}', [followerController::class, 'GetFollowersList']); //Returns list of all usernames of followers

Route::get('/followers/list/followed/{userid}', [followerController::class, 'GetFollowedList']); //Returns list of all usernames of followed

//Community
//Route::get('/community/{community name}/{userid}', [communityController::class, 'LevelOfAuthority']); //Returns level of authroity
//[unauthrised, memeber, mod, owener] of a community

//Route::patch('/community/{community name}/join/{userid}', [communityController::class, 'JoinCommunity']); //Allows user to join community

//Route::get('/community/{community name}/leave/{userid}', [communityController::class, 'LeaveCommunity']); //Allows user to leave

//Route::get('/community/{community name}/transferownership/{userid}', [communityController::class, 'TransferOwnership']); //Allows for community ownership transfer
