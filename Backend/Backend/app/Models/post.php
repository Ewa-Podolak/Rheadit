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

    public function GetHomePage($page, $userid)
    {
        $allposts = $this::orderby('created_at')->get();

        $numberofpostsmax = $allposts->count();
        $postsarray = [];
        if($numberofpostsmax + 1 == $page * 10)
            return ['postid' => null, 'head' => null, 'body' => null];
        else
            for($x = (($page - 1) * 10); $x < $page * 10; $x++)
            {
                if($x < $numberofpostsmax)
                {
                    $username = user::where('userid', $allposts[$x]->userid)->first()->username; 
                    $profilepic = user::where('userid', $allposts[$x]->userid)->first()->profilepic;
                    $voted = interaction::where('userid', $userid)->where('postid', $allposts[$x]->postid)->get();
                    if(!$voted->IsEmpty())
                    {
                        if($voted[0]->liked == 1)
                            $voted = 'upvote';
                        else
                            $voted = 'downvoted';
                    }
                    else
                        $voted = null;
                    $votes = $this->Votes($allposts[$x]->postid);
                    array_push($postsarray, ['postid'=>$allposts[$x]->postid, 'head'=>$allposts[$x]->head, 'body'=>$allposts[$x]->body,'username'=>$username,
                    'profilepic'=>$profilepic, 'votes'=>$votes, 'voted'=>$voted, 'community'=>$allposts[$x]->community, 'created_at'=>$allposts[$x]->created_at]);
                }
            }
        return($postsarray);
    }

    public function GetExploreHomePage($page, $userid)
    {
        $allposts = $this::
        orderby('created_at')->get();
        $allcommunities = community::where('userid', $userid)->get();
        $numberofpostsmax = $allposts->count();

        for($x = 0; $x<$numberofpostsmax; $x++)
        {
            foreach($allcommunities as $community)
            {
                if($allposts[$x]->community == $community->community)
                {
                    unset($allposts[$x]);
                }
            }
        }
        $numberofpostsmax = $allposts->count();
        $postsarray = [];
        $x = 0;
        $tempallposts = $allposts;
        foreach($tempallposts as $post)
        {
            $allposts[$x]=$post;
            $x++;
        }

        if($numberofpostsmax + 1 == $page * 10)
            return ['postid' => null, 'head' => null, 'body' => null];
        else
            for($x = (($page - 1) * 10); $x < $page * 10; $x++)
            {
                if($x < $numberofpostsmax)
                {
                    $username = user::where('userid', $allposts[$x]->userid)->first()->username; 
                    $profilepic = user::where('userid', $allposts[$x]->userid)->first()->profilepic; 
                    $voted = interaction::where('userid', $userid)->where('postid', $allposts[$x]->postid)->get();
                    if(!$voted->IsEmpty())
                    {
                        if($voted[0]->liked == 1)
                            $voted = 'upvote';
                        else
                            $voted = 'downvoted';
                    }
                    else
                        $voted = null;
                    $votes = $this->Votes($allposts[$x]->postid);
                    array_push($postsarray, ['postid'=>$allposts[$x]->postid, 'head'=>$allposts[$x]->head, 'body'=>$allposts[$x]->body,'username'=>$username, 
                    'profilepic'=>$profilepic, 'votes'=>$votes, 'voted'=>$voted, 'community'=>$allposts[$x]->community, 'created_at'=>$allposts[$x]->created_at]);
                }
            }
        return($postsarray);
    }

    public function ReturnPost($postid, $userid)
    {
        $post = $this::where('postid', $postid)->first();
        $votes = $this->Votes($postid);
        $username = user::where('userid', $post->userid)->first()->username; 
        $profilepic = user::where('userid', $post->userid)->first()->profilepic;

        $voted = interaction::where('userid', $userid)->where('postid', $postid)->get();
                    if(!$voted->IsEmpty())
                    {
                        if($voted[0]->liked == 1)
                            $voted = 'upvote';
                        else
                            $voted = 'downvoted';
                    }
                    else
                        $voted = null;

        return ['postid'=>$post->postid, 'head'=>$post->head, 'body'=>$post->body, 'username'=>$username, 'profilepic'=>$profilepic, 'votes'=>$votes, 'voted'=>$voted, 'community'=>$post->community, 'created_at'=>$post->created_at];
    }

    public function PostInCommunity($community, $userid, $head, $body)
    {
        if(community::where('userid', $userid)->where('community', $community)->get()->IsEmpty())
            return ['created'=>false];
        else
        {
            $this::insert(['userid'=>$userid, 'head'=>$head, 'body'=>$body, 'community'=>$community]);
            return ['created' => true];
        }
    }

    public function Votes($postid)
    {
        $upvotes = interaction::where('postid', $postid)->where('liked', 1)->get()->count();
        $downvotes = interaction::where('postid', $postid)->where('liked', 0)->get()->count();
        return $upvotes-$downvotes;
    }


    public function GetUserNewestPosts($userid, $page)
    {
        $posts = $this::where('userid', $userid)->orderby('created_at', 'asc')->get();

        if($posts->count() + 1 == $page * 5)
        {
            return ['postid' => null, 'head' => null, 'body' => null, 'votes' => null, 'created_at'=>null, 'username'=>null, 'voted'=>null, 'community'=>null];
        }
        else
        {
            $endarray = [];
            for($x = ($page - 1) * 5; $x < ($page * 5); $x++)
            {
                if($x < $posts->count())
                {
                    $votes = $this->Votes($posts[$x]->postid);
                    $postuserid = $this::where('postid', $posts[$x]->postid)->first()->userid;
                    $username = user::where('userid', $postuserid)->first()->username;
                    $profilepic = user::where('userid', $postuserid)->first()->profilepic;
                    $voted = interaction::where('userid', $userid)->where('postid', $posts[$x]->commentid)->get();
                    if(!$voted->IsEmpty())
                    {
                        if($voted[0]->liked == 1)
                            $voted = 'upvote';
                        else
                            $voted = 'downvoted';
                    }
                    else
                        $voted = null;

                    array_push($endarray,
                    ['postid' => $posts[$x]->postid, 
                    'head' => $posts[$x]->head, 
                    'body' => $posts[$x]->body, 
                    'votes' => $votes, 
                    'created_at'=>$posts[$x]->created_at, 
                    'username'=>$username, 
                    'profilepic'=>$profilepic,
                    'voted'=>$voted,
                    'community'=>$posts[$x]->community]);
                }
            }
        }

        return $endarray;
    }

    public function GetUserLikedPosts($userid, $page)
    {
        $posts = $this::where('userid', $userid)->orderby('created_at', 'asc')->get();

        if($posts->count() + 1 == $page * 5)
        {
            return ['postid' => null, 'head' => null, 'body' => null, 'votes' => null, 'created_at'=>null, 'username'=>null, 'voted'=>null, 'community'=>null];
        }
        else
        {
            $endarray = [];

            foreach($posts as $post)
            {
                $votes = $this->Votes($post->postid);
                $postuserid = $this::where('postid', $post->postid)->first()->userid;
                $username = user::where('userid', $postuserid)->first()->username;
                $profilepic = user::where('userid', $postuserid)->first()->profilepic;
                $voted = interaction::where('userid', $userid)->where('postid', $post->postid)->get();
                if(!$voted->IsEmpty())
                {
                    if($voted[0]->liked == 1)
                        $voted = 'upvote';
                    else
                        $voted = 'downvoted';
                }
                else
                    $voted = null;

                array_push($endarray,
                ['postid' => $post->postid, 
                'head' => $post->head, 
                'body' => $post->body, 
                'votes' => $votes, 
                'created_at'=>$post->created_at, 
                'username'=>$username, 
                'profilepic'=>$profilepic,
                'voted'=>$voted,
                'community'=>$post->community]);

                $votes = array_column($endarray, 'votes');
                array_multisort($votes, SORT_DESC, $endarray);
            }
        }

        return $endarray;
    }

    public function GetCommunityNewestPosts($community, $userid, $page)
    {
        $posts = $this::where('community', $community)->orderby('created_at', 'asc')->get();

        if($posts->count() + 1 == $page * 10)
        {
            return ['postid' => null, 'head' => null, 'body' => null, 'votes' => null, 'created_at'=>null, 'username'=>null, 'voted'=>null, 'community'=>null];
        }
        else
        {
            $endarray = [];
            for($x = ($page - 1) * 10; $x < ($page * 10); $x++)
            {
                if($x < $posts->count())
                {
                    $votes = $this->Votes($posts[$x]->postid);
                    $postuserid = $this::where('postid', $posts[$x]->postid)->first()->userid;
                    $username = user::where('userid', $postuserid)->first()->username;
                    $profilepic = user::where('userid', $postuserid)->first()->profilepic;
                    $voted = interaction::where('userid', $userid)->where('postid', $posts[$x]->commentid)->get();
                    if(!$voted->IsEmpty())
                    {
                        if($voted[0]->liked == 1)
                            $voted = 'upvote';
                        else
                            $voted = 'downvoted';
                    }
                    else
                        $voted = null;

                    array_push($endarray,
                    ['postid' => $posts[$x]->postid, 
                    'head' => $posts[$x]->head, 
                    'body' => $posts[$x]->body, 
                    'votes' => $votes, 
                    'created_at'=>$posts[$x]->created_at, 
                    'username'=>$username, 
                    'profilepic'=>$profilepic,
                    'voted'=>$voted,
                    'community'=>$posts[$x]->community]);
                }
            }
        }

        return $endarray;
    }

    public function GetCommunityLikedPosts($community, $userid, $page)
    {
        $posts = $this::where('community', $community)->orderby('created_at', 'asc')->get();

        if($posts->count() + 1 == $page * 5)
        {
            return ['postid' => null, 'head' => null, 'body' => null, 'votes' => null, 'created_at'=>null, 'username'=>null, 'voted'=>null, 'community'=>null];
        }
        else
        {
            $endarray = [];

            foreach($posts as $post)
            {
                $votes = $this->Votes($post->postid);
                $postuserid = $this::where('postid', $post->postid)->first()->userid;
                $username = user::where('userid', $postuserid)->first()->username;
                $profilepic = user::where('userid', $postuserid)->first()->profilepic;
                $voted = interaction::where('userid', $userid)->where('postid', $post->postid)->get();
                if(!$voted->IsEmpty())
                {
                    if($voted[0]->liked == 1)
                        $voted = 'upvote';
                    else
                        $voted = 'downvoted';
                }
                else
                    $voted = null;

                array_push($endarray,
                ['postid' => $post->postid, 
                'head' => $post->head, 
                'body' => $post->body, 
                'votes' => $votes, 
                'created_at'=>$post->created_at, 
                'username'=>$username, 
                'profilepic'=>$profilepic,
                'voted'=>$voted,
                'community'=>$post->community]);

                $votes = array_column($endarray, 'votes');
                array_multisort($votes, SORT_DESC, $endarray);
            }
        }

        return $endarray;
    }



    public function DeletePost($postid, $userid) //When the user deletes their post
    {
        $comments = new comment;
        $interactions = new interaction;
        $community = post::where('postid', $postid)->first()->community;
        $authority = community::where('community', $community)->where('userid', $userid)->first()->authority;

        if($this::where('postid', $postid)->first()->userid == $userid || $authority == 'mod' || $authority == 'owner')
        {
        //Delete Comments
        $tobedeletedcomments = $comments::where('postid', $postid)->get();

        foreach($tobedeletedcomments as $comment)
            $comments->DeletedPost($comment->commentid);

        //Delete Likes
        $interactions->DeleteLikesPost($postid);

        return ['Delted'=>true];
        }

        return ['Deleted'=>false];
    }

    public function DeletePosts($postid) //When user deleted so multiple posts are deleted 
    {
        $comments = new comment;
        $interactions = new interaction;

        //Delete Comments
        $tobedeletedcomments = $comments->DeletedPost(comment::where('postid', $postid)->get());

        foreach($tobedeletedcomments as $comment)
            $comments->DeletedPost($comment->commentid);


        //Delete Likes
        $interactions->DeleteLikesPost($postid);
    }
}
