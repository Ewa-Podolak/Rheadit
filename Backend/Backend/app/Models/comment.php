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
        $commentinfo = comment::where('commentid', $commentid);
        if(post::where('postid', $postid)->first()->userid == $userid && $commentinfo->first()->favourited == 0)
        {
            $commentinfo->update(['favourited'=>1]);
            return ['favourited'=>true];
        }
        else if(post::where('postid', $postid)->first()->userid == $userid && $commentinfo->first()->favourited == 1)
        {
            $commentinfo->update(['favourited'=>0]);
            return ['favourited'=>true];
        }
        return ['favourited'=>false];
    }
    
    public function CreateComment($postid, $comment, $userid)
    {
        $community = post::where('postid', $postid)->first()->community;
        if($this->GetAuthority($userid, $community) > 0)
        {
            $this::insert(['postid'=>$postid, 'userid'=>$userid, 'comment'=>$comment]);
            return ['created'=>true];
        }
        else
            return ['created'=>false];
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



    public function DeletedPost($commentids) //WhenPost is deleted
    {
        $interaction = new interaction;

        $interaction->DeleteLikesComment($commentids);
        $this::where('commentid', $commentids)->delete();
    }

    public function DeletedComment($commentid, $userid) //When the comment is deleted
    {
        $interaction = new interaction;
        if($this::where('commentid', $commentid)->first()->userid == $userid)
        {
            $interaction->DeleteLikesComment($commentid);
            $this::where('commentid', $commentid)->delete();
            return ['deleted'=>true];
        }
        return ['deleted'=>false];
    }
}