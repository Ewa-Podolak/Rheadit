<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interaction extends Model
{
    use HasFactory;

    protected $table = 'interactions';

    public $timestamps = false;

    public function UpvotePost($postid, $userid)
    {
        $interaction = $this::where('userid', $userid)->where('postid', $postid)->get();
        if ($interaction->IsEmpty()) {
            $authority = $this->GetAuthority($userid, (post::where('postid', $postid)->first()->community));
            if ($authority > 0) {
                $this::insert(['userid' => $userid, 'postid' => $postid, 'liked' => 1]);

                return ['upvoted' => true];
            }
        } elseif ($interaction[0]->liked == 0) { //DownVoted by user
            $this::where('postid', $postid)->where('userid', $userid)->update(['liked' => 1]);

            return ['upvoted' => true];
        } elseif ($interaction[0]->liked == 1) { //UpVoted by user
            $this::where('postid', $postid)->where('userid', $userid)->delete();

            return ['upvoted' => true];
        }

        return ['upvoted' => false];
    }

    public function DownvotePost($postid, $userid)
    {
        $interaction = $this::where('userid', $userid)->where('postid', $postid)->get();
        if ($interaction->IsEmpty()) {
            $authority = $this->GetAuthority($userid, (post::where('postid', $postid)->first()->community));
            if ($authority > 0) {
                $this::insert(['userid' => $userid, 'postid' => $postid, 'liked' => 0]);

                return ['downvote' => true];
            }
        } elseif ($interaction[0]->liked == 1) { //DownVoted by user
            $this::where('postid', $postid)->where('userid', $userid)->update(['liked' => 0]);

            return ['downvote' => true];
        } elseif ($interaction[0]->liked == 0) { //UpVoted by user
            $this::where('postid', $postid)->where('userid', $userid)->delete();

            return ['downvote' => true];
        }

        return ['downvote' => false];
    }

    public function UpvoteComment($commentid, $userid)
    {
        $interaction = $this::where('userid', $userid)->where('commentid', $commentid)->get();
        $postid = comment::where('commentid', $commentid)->first()->postid;
        $community = post::where('postid', $postid)->first()->community;

        if ($interaction->IsEmpty()) {
            $authority = $this->GetAuthority($userid, ($community));
            if ($authority > 0) {
                $this::insert(['userid' => $userid, 'commentid' => $commentid, 'liked' => 1]);

                return ['upvoted' => true];
            }
        } elseif ($interaction[0]->liked == 0) { //DownVoted by user
            $this::where('commentid', $commentid)->where('userid', $userid)->update(['liked' => 1]);

            return ['upvoted' => true];
        } elseif ($interaction[0]->liked == 1) { //UpVoted by user
            $this::where('commentid', $commentid)->where('userid', $userid)->delete();

            return ['upvoted' => true];
        }

        return ['upvoted' => false];
    }

    public function DownvoteComment($commentid, $userid)
    {
        $interaction = $this::where('userid', $userid)->where('commentid', $commentid)->get();
        $postid = comment::where('commentid', $commentid)->first()->postid;
        $community = post::where('postid', $postid)->first()->community;

        if ($interaction->IsEmpty()) {
            $authority = $this->GetAuthority($userid, ($community));
            if ($authority > 0) {
                $this::insert(['userid' => $userid, 'commentid' => $commentid, 'liked' => 0]);

                return ['downvote' => true];
            }
        } elseif ($interaction[0]->liked == 1) { //DownVoted by user
            $this::where('commentid', $commentid)->where('userid', $userid)->update(['liked' => 0]);

            return ['downvote' => true];
        } elseif ($interaction[0]->liked == 0) { //UpVoted by user
            $this::where('commentid', $commentid)->where('userid', $userid)->delete();

            return ['downvote' => true];
        }

        return ['downvote' => false];
    }

    public function GetAuthority($userid, $community)
    {
        $communitystatus = community::where('userid', $userid)->where('community', $community)->get();
        if (! $communitystatus->IsEmpty()) {
            switch ($communitystatus[0]->authority) {
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
        } else {
            return 0;
        }
    }

    public function DeleteLikesPost($postid) //When post is deleted
    {
        $this::where('postid', $postid)->delete();
    }

    public function DeleteLikesComment($commentid) //When comment is deleted
    {
        $this::where('commentid', $commentid)->delete();
    }
}
