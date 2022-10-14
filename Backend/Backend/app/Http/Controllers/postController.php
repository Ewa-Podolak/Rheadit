<?php

namespace App\Http\Controllers;

use App\Models\community;
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

    public function GetUserNewestPosts($username, $page)
    {
        $post = new post;

        return $post->GetUserNewestPosts($username, $page);
    }

    public function GetUserLikedPosts($username, $page)
    {
        $post = new post;

        return $post->GetUserLikedPosts($username, $page);
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
        $head = request()->head;
        $body = request()->body;
        $picture = request()->picture;

        if (community::where('userid', $userid)->where('community', $community)->get()->IsEmpty()) {
            return ['created' => false];
        } else {
            post::insert(['userid' => $userid, 'head' => $head, 'body' => $body, 'picture' => $picture, 'community' => $community]);

            return ['created' => true];
        }
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
