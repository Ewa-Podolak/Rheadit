<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    public $timestamps = false;

    public function GetComments($postid, $page)
    {
        $allcomments = $this::orderby('created_at');
        return $allcomments->get();
    }

    public function Votes($postid)
    {
        $upvotes = interaction::where('postid', $postid)->where('liked', 1)->get()->count();
        $downvotes = interaction::where('postid', $postid)->where('liked', 0)->get()->count();
        return $upvotes-$downvotes;
    }
    
    public function FavouriteComment($postid, $commentid, $userid)
    {
        
    }
    
    public function CreateComment($postid, $title, $body, $userid)
    {
    
    }
    
    public function DeleteComment($commentid, $userid)
    {
    
    }
    
    public function GetAuthority($userid, $community)
    {
        $communitystatus = community::where('userid', $userid)->where('community', $community)->get();
        if(!$communitystatus->IsEmpty())
        {
            switch ($communitystatus[0]->authority)
            {
                case 'member':
                    $auth = 1;
                    break;
                case 'mod':
                    $auth = 2;
                    break;
                case 'owner':
                    $auth = 3;
                    break;
            }
            return $auth;
        }
        else
            return 0;
    }
}