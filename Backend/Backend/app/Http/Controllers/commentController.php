<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;

class commentController extends Controller
{
    public function GetComments($postid, $page)
    {
        $comment = new comment;
        $comment->GetComments($postid, $page);
    }

    public function UpvoteComment($postid, $userid)
    {
        $comment = new comment;
        $comment->UpvoteComment($postid, $userid);
    }

    public function DownvoteComment($postid, $userid)
    {
        $comment = new comment;
        $comment->DownvoteComment($postid, $userid);
    }

    public function FavouriteComment($postid, $userid)
    {
        $comment = new comment;
        $comment->FavouriteComment($postid, $userid);
    }

    public function CreateComment($postid, $userid)
    {
        $comment = new comment;
        $comment->CreateComment($postid, $userid);
    }

    public function DeleteComment($postid, $userid)
    {
        $comment = new comment;
        $comment->DeleteComment($postid, $userid);
    }
}