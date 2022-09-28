<?php

namespace App\Http\Controllers;

use App\Models\interaction;
use Illuminate\Http\Request;

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
}
