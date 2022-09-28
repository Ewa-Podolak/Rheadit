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
    
    public function UpvoteComment($postid, $userid)
    {
    
    }
    
    public function DownvoteComment($postid, $userid)
    {
    
    }
    
    public function FavouriteComment($postid, $userid)
    {
    
    }
    
    public function CreateComment($postid, $userid)
    {
    
    }
    
    public function DeleteComment($postid, $userid)
    {
    
    }
    
   
}