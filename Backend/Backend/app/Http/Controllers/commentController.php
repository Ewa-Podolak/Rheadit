<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;

class commentController extends Controller
{
    public function GetComments($postid, $page)
    {
        $comment = new comment;
        return $comment->GetComments($postid, $page);
    }

    public function FavouriteComment($postid, $commentid, $userid)
    {
        $comment = new comment;
        $comment->FavouriteComment($postid, $commentid, $userid);
    }

    public function CreateComment($postid, $title, $body, $userid)
    {
        $comment = new comment;
        $comment->CreateComment($postid, $title, $body, $userid);
    }

    public function DeleteComment($commentid, $userid)
    {
        $comment = new comment;
        $comment->DeleteComment($commentid, $userid);
    }
}