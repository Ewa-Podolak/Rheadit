<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;

class postController extends Controller
{
    public function GetHomepagePosts($pagenumber)
    {
        $post = new post;
        return $post->GetHomePage($pagenumber);
    }

    public function GetUserNewestPosts($userid)
    {


    }

    public function GetUserLikedPosts($userid)
    {

    }

    public function GetCommunityNewestPosts($community)
    {

    }

    public function GetCommunityLikedPosts($community)
    {

    }

    public function UpvotePost($postid, $userid)
    {

    }

    public function DownvotePost($postid, $userid)
    {

    }

    public function PostInCommunity($community, $userid)
    {

    }

    public function DeletePost($postid, $userid)
    {

    }

    public function ReturnPost($postid)
    {

    }
}
