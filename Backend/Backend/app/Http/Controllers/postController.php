<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;

class postController extends Controller
{
    public function GetHomepagePosts($pagenumber, $userid)
    {
        $post = new post;
        return $post->GetHomePage($pagenumber, $userid);
    }

    public function GetExploreHomePage($pagenumber, $userid)
    {
        $post = new post;
        return $post->GetExploreHomePage($pagenumber, $userid);
    }

    public function GetUserNewestPosts($userid, $page)
    {
        $post = new post;
        return $post->GetUserNewestPosts($userid, $page);
    }

    public function GetUserLikedPosts($userid, $page)
    {
        $post = new post;
        return $post->GetUserLikedPosts($userid, $page);
    }

    public function GetCommunityNewestPosts($community, $userid, $page)
    {
        $post = new post;
        return $post->GetCommunityNewestPosts($community, $userid, $page);
    }

    public function GetCommunityLikedPosts($community, $userid, $page)
    {
        $post = new post;
        return $post->GetCommunityLikedPosts($community, $userid, $page);
    }

    public function PostInCommunity($community, $userid)
    {
        $post = new post;
        $title = request()->title;
        $body = request()->body;
        $picture = request()->picture;
        return $post->PostInCommunity($community, $userid, $title, $body, $picture);
    }

    public function DeletePost($postid, $userid)
    {
        $post = new post;
        return $post->DeletePost($postid, $userid);
    }

    public function ReturnPost($postid, $userid)
    {
        $post = new post;
        return $post->ReturnPost($postid, $userid);
    }
}
