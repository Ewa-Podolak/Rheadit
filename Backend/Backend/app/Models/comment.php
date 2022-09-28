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
        $allfavouritecomments = $this::where('postid', $postid)->where('favourited', 1)->orderby('created_at')->get();
        $allnotfavouritecomments = $this::where('postid', $postid)->where('favourited', 0)->orderby('created_at')->get();

        $favouritecommentarray = [];
        $notfavouritecommentarray = [];
        
        foreach($allfavouritecomments as $comment)
        {
            $comment['votes'] = $this->Votes($comment->commentid);
            array_push($favouritecommentarray, ['commentid'=>$comment->commentid, 
                                                'comment'=>$comment->comment, 
                                                'votes'=>$comment->votes, 
                                                'favourited'=>true,
                                                'created_at'=>$comment->created_at, 
                                                'username'=>user::where('userid', $comment->userid)->first()->username]);
        }

        foreach($allnotfavouritecomments as $comment)
        {
            $comment['votes'] = $this->Votes($comment->commentid);
            $comment['votes'] = $this->Votes($comment->commentid);
            array_push($notfavouritecommentarray, ['commentid'=>$comment->commentid, 
                                                'comment'=>$comment->comment, 
                                                'votes'=>$comment->votes, 
                                                'favourited'=>false,
                                                'created_at'=>$comment->created_at, 
                                                'username'=>user::where('userid', $comment->userid)->first()->username]);
        }

        $votes = array_column($favouritecommentarray, 'votes');
        array_multisort($votes, SORT_DESC, $favouritecommentarray);

        $votes = array_column($notfavouritecommentarray, 'votes');
        array_multisort($votes, SORT_DESC, $notfavouritecommentarray);

        $commentsarray = array_merge($favouritecommentarray, $notfavouritecommentarray);


        if(count($commentsarray) + 1 == $page * 5)
        {
            return ['commentid' => null, 'comment' => null, 'votes' => null, 'favourited'=>null, 'created_at'=>null, 'usesrname'=>null];
        }
        else
        {
            $endarray = [];
            for($x = ($page -1) * 5; $x < ($page * 5); $x++)
            {
                if($x < count($commentsarray))
                    array_push($endarray, $commentsarray[$x]);
            }
        }

        return $endarray;
    }

    public function Votes($commentid)
    {
        $upvotes = interaction::where('commentid', $commentid)->where('liked', 1)->get()->count();
        $downvotes = interaction::where('commentid', $commentid)->where('liked', 0)->get()->count();
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