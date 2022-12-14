<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    public $timestamps = false;

    public function GetComments($postid, $page, $userid)
    {
        $allfavouritecomments = $this::where('postid', $postid)->where('favourited', 1)->orderby('created_at')->get();
        $allnotfavouritecomments = $this::where('postid', $postid)->where('favourited', 0)->orderby('created_at')->get();

        $favouritecommentarray = [];
        $notfavouritecommentarray = [];

        foreach ($allfavouritecomments as $comment) {
            $comment['votes'] = $this->Votes($comment->commentid);
            $voted = interaction::where('userid', $userid)->where('commentid', $comment->commentid)->get();
            if (! $voted->IsEmpty()) {
                if ($voted[0]->liked == 1) {
                    $voted = 'upvote';
                } else {
                    $voted = 'downvoted';
                }
            } else {
                $voted = null;
            }
            array_push($favouritecommentarray, ['commentid' => $comment->commentid,
                'comment' => $comment->comment,
                'votes' => $comment->votes,
                'favourited' => true,
                'created_at' => $comment->created_at,
                'username' => user::where('userid', $comment->userid)->first()->username,
                'profilepic' => user::where('userid', $comment->userid)->first()->profilepic,
                'voted' => $voted, ]);
        }

        foreach ($allnotfavouritecomments as $comment) {
            $comment['votes'] = $this->Votes($comment->commentid);
            $voted = interaction::where('userid', $userid)->where('commentid', $comment->commentid)->get();
            if (! $voted->IsEmpty()) {
                if ($voted[0]->liked == 1) {
                    $voted = 'upvote';
                } else {
                    $voted = 'downvoted';
                }
            } else {
                $voted = null;
            }
            array_push($notfavouritecommentarray, ['commentid' => $comment->commentid,
                'comment' => $comment->comment,
                'votes' => $comment->votes,
                'favourited' => false,
                'created_at' => $comment->created_at,
                'username' => user::where('userid', $comment->userid)->first()->username,
                'profilepic' => user::where('userid', $comment->userid)->first()->profilepic,
                'voted' => $voted, ]);
        }

        $votes = array_column($favouritecommentarray, 'votes');
        array_multisort($votes, SORT_DESC, $favouritecommentarray);

        $votes = array_column($notfavouritecommentarray, 'votes');
        array_multisort($votes, SORT_DESC, $notfavouritecommentarray);

        $commentsarray = array_merge($favouritecommentarray, $notfavouritecommentarray);

        if (count($commentsarray) == ($page - 1) * 5) {
            return ['commentid' => null, 'comment' => null, 'votes' => null, 'favourited' => null, 'created_at' => null, 'usesrname' => null, 'profilepic' => null, 'voted' => null];
        } else {
            $endarray = [];
            for ($x = ($page - 1) * 5; $x < ($page * 5); $x++) {
                if ($x < count($commentsarray)) {
                    array_push($endarray, $commentsarray[$x]);
                }
            }
        }

        return $endarray;
    }

    public function Votes($commentid)
    {
        $upvotes = interaction::where('commentid', $commentid)->where('liked', 1)->get()->count();
        $downvotes = interaction::where('commentid', $commentid)->where('liked', 0)->get()->count();

        return $upvotes - $downvotes;
    }

    public function FavouriteComment($postid, $commentid, $userid)
    {
        $commentinfo = comment::where('commentid', $commentid);
        if (post::where('postid', $postid)->first()->userid == $userid && $commentinfo->first()->favourited == 0) {
            $commentinfo->update(['favourited' => 1]);

            return ['favourited' => true];
        } elseif (post::where('postid', $postid)->first()->userid == $userid && $commentinfo->first()->favourited == 1) {
            $commentinfo->update(['favourited' => 0]);

            return ['favourited' => true];
        }

        return ['favourited' => false];
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

    public function DeletedPost($commentid) //WhenPost is deleted
    {
        $interaction = new interaction;

        $interaction->DeleteLikesComment($commentid);
        $this::where('commentid', $commentid)->delete();
    }

    public function DeletedComment($commentid, $userid) //When the comment is deleted
    {
        $interaction = new interaction;
        $postid = $this::where('commentid', $commentid)->first()->postid;
        $community = post::where('postid', $postid)->first()->community;
        $authority = $this->GetAuthority($userid, $community);

        if ($this::where('commentid', $commentid)->first()->userid == $userid || $authority > 1) {
            $interaction->DeleteLikesComment($commentid);
            $this::where('commentid', $commentid)->delete();

            return ['deleted' => true];
        }

        return ['deleted' => false];
    }
}
