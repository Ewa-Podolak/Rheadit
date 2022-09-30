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
        
        // $validated = request()->validate([
        //     'title' => 'required|unique:posts|max:1',
        //     'body' => ['required', 'max:8'],
        // ]);
        // dd('jk');

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
