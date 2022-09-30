<?php

namespace App\Http\Controllers;

use App\Models\comment;

class commentController extends Controller
{
    public function GetComments($postid, $page, $userid)
    {
        $comment = new comment;
        return $comment->GetComments($postid, $page, $userid);
    }

    public function FavouriteComment($postid, $commentid, $userid)
    {
        $comment = new comment;
        return $comment->FavouriteComment($postid, $commentid, $userid);
    }

    public function CreateComment($postid, $commenttext, $userid)
    {
        $comment = new comment;
        return $comment->CreateComment($postid, $commenttext, $userid);
    }

    public function DeleteComment($commentid, $userid)
    {
        $comment = new comment;
        return $comment->DeletedComment($commentid, $userid);
    }
}