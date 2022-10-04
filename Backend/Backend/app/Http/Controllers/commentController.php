<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;

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

    public function CreateComment($postid, $userid)
    {
        $comment = new comment;
        $commenttext = request()->comment;
        $community = post::where('postid', $postid)->first()->community;
        if($comment->GetAuthority($userid, $community) > 0)
        {
            comment::insert(['postid'=>$postid, 'userid'=>$userid, 'comment'=>$commenttext]);
            return ['created'=>true];
        }
        else
            return ['created'=>false];
    }

    public function DeleteComment($commentid, $userid)
    {
        $comment = new comment;
        return $comment->DeletedComment($commentid, $userid);
    }
}