<?php

namespace App\Http\Controllers;

use App\Models\interaction;

class interactionController extends Controller
{
    public function UpvotePost($postid, $userid)
    {
        $post = new interaction;
        return $post->UpvotePost($postid, $userid);
    }

    public function DownvotePost($postid, $userid)
    {
        $post = new interaction;
        return $post->DownvotePost($postid, $userid);
    }

    public function UpvoteComment($commentid, $userid)
    {
        $post = new interaction;
        return $post->UpvoteComment($commentid, $userid);
    }

    public function DownvoteComment($commentid, $userid)
    {
        $post = new interaction;
        return $post->DownvoteComment($commentid, $userid);
    }
}
