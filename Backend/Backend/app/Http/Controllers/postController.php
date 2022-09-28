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

    public function PostInCommunity($community, $userid)
    {
        $post = new post;
        return $post->PostInCommunity($community, $userid);
    }

    public function DeletePost($postid, $userid)
    {
        $post = new post;
        return $post->DeletePost($postid, $userid);
    }

    public function ReturnPost($postid)
    {
        $post = new post;
        return $post->ReturnPost($postid);
    }
}
