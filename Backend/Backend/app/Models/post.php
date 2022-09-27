<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Symfony\Component\HttpFoundation\count;

class post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    public $timestamps = false;

    public function GetHomePage($page)
    {
        $allposts = $this::orderby('created_at')->get();
        $numberofpostsmax = $allposts->count();
        $postsarray = [];
        if($numberofpostsmax + 1 == $page * 10)
            return ['postid' => null, 'title' => null, 'body' => null];
        else
            for($x = (($page - 1) * 10); $x < $numberofpostsmax; $x++)
            {
                $username = user::where('userid', $allposts[$x]->userid)->first()->username; 
                $votes = $this->Votes($allposts[$x]->postid);
                array_push($postsarray, ['postid'=>$allposts[$x]->postid, 'head'=>$allposts[$x]->title, 'body'=>$allposts[$x]->title, 'username'=>$username, 'votes'=>$votes]);
            }
        return($postsarray);
    }

    public function ReturnPost($postid)
    {
        $post = $this::where('postid', $postid)->first();
        $votes = $this->Votes($postid);
        $username = user::where('userid', $post->userid)->first()->username; 

        return ['head'=>$post->title, 'upvotes'=> $votes, 'username'=>$username, 'community'=>$post->title];
    }

    public function DeletePost($postid, $userid)
    {
        if(($this::where('postid', $postid)->first())->userid == $userid)
        {   
            $comments = comment::where('postid', $postid)->get();
            foreach($comments as $x)
                interaction::where('commentid', $x->commentid)->delete();
            comment::where('postid', $postid)->delete();
            interaction::where('postid', $postid)->delete();
            $this::where('postid', $postid)->delete();
            return ['deleted'=>true];
        }
        else
            return ['deleted'=>false];
    }

    public function PostInCommunity($community, $userid)
    {
        // $communitystatus = communitymember::where('userid', $userid)->where('community', $community)->first();
        // if(!$communitystatus->IsEmpty() && ($communitystatus->authority == 'member' || $communitystatus->authority == 'mod' || $communitystatus->authority == 'owner')
        // {
            
        // }
    }

    public function Votes($postid)
    {
        $upvotes = interaction::where('postid', $postid)->where('liked', 1)->get()->count();
        $downvotes = interaction::where('postid', $postid)->where('liked', 0)->get()->count();
        return $upvotes-$downvotes;
    }

    public function UpvotePost($postid, $userid)
    {
        $interaction = interaction::where('userid', $userid)->where('postid', $postid)->get();
        if($interaction->IsEmpty())
        {
            $authority = $this->GetAuthority($userid, ($this::where('postid', $postid)->first()->community));
            if ($authority > 0)
            {
                interaction::insert(['userid'=>$userid, 'postid'=>$postid, 'liked'=>1]);
                return ['upvoted'=>true];
            }
        }
        else if($interaction[0]->liked == 0) //DownVoted by user
        {
            interaction::where('postid', $postid)->where('userid', $userid)->update(['upvote'=>1]);
            return ['upvoted'=>true];
        }
        else if($interaction[0]->liked == 1) //UpVoted by user
        {
            interaction::where('postid', $postid)->where('userid', $userid)->delete();
            return ['upvoted'=>true];
        }

        return ['upvoted'=>false];
    }

    public function DownvotePost($postid, $userid)
    {
        $interaction = interaction::where('userid', $userid)->where('postid', $postid)->get();
        if($interaction->IsEmpty())
        {
            $authority = $this->GetAuthority($userid, ($this::where('postid', $postid)->first()->community));
            if ($authority > 0)
            {
                interaction::insert(['userid'=>$userid, 'postid'=>$postid, 'liked'=>0]);
                return ['downvote'=>true];
            }
        }
        else if($interaction[0]->liked == 1) //DownVoted by user
        {
            interaction::where('postid', $postid)->where('userid', $userid)->update(['liked'=>0]);
            return ['downvote'=>true];
        }
        else if($interaction[0]->liked == 0) //UpVoted by user
        {
            interaction::where('postid', $postid)->where('userid', $userid)->delete();
            return ['downvote'=>true];
        }

        return ['downvote'=>false];
    }

    public function GetAuthority($userid, $community)
    {
        $communitystatus = community::where('userid', $userid)->where('community', $community)->get();
        if(!$communitystatus->IsEmpty())
        {
            switch ($communitystatus[0]->authority)
            {
                case 'memeber':
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
