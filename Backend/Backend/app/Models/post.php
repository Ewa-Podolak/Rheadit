<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    public $timestamps = false;

    public function GetHomePage($page, $userid)
    {
        $allposts = $this::orderby('created_at')->get();
        $allcommunites = community::where('userid', $userid)->get();

        $numberofpostsmax = $allposts->count();
        $postsarray = [];
        if ($numberofpostsmax == ($page - 1) * 10) {
            return [];
        } else {
            for ($x = (($page - 1) * 10); $x < $page * 10; $x++) {
                if ($x < $numberofpostsmax) {
                    $partofcommunity = false;
                    foreach ($allcommunites as $community) {
                        if (! $partofcommunity && ! $allposts->IsEmpty()) {
                            if ($allposts[$x]->community == $community->community) {
                                $username = user::where('userid', $allposts[$x]->userid)->first()->username;
                                $profilepic = user::where('userid', $allposts[$x]->userid)->first()->profilepic;
                                $voted = interaction::where('userid', $userid)->where('postid', $allposts[$x]->postid)->get();
                                $commentnumber = comment::where('postid', $allposts[$x]->postid)->get()->count();
                                if (! $voted->IsEmpty()) {
                                    if ($voted[0]->liked == 1) {
                                        $voted = 'upvote';
                                    } else {
                                        $voted = 'downvoted';
                                    }
                                } else {
                                    $voted = null;
                                }
                                $votes = $this->Votes($allposts[$x]->postid);
                                array_push($postsarray, ['postid' => $allposts[$x]->postid, 'head' => $allposts[$x]->head, 'body' => $allposts[$x]->body, 'picture' => $allposts[$x]->picture,
                                    'username' => $username, 'profilepic' => $profilepic, 'votes' => $votes, 'voted' => $voted, 'community' => $allposts[$x]->community,
                                    'created_at' => $allposts[$x]->created_at, 'commentsnumber' => $commentnumber, ]);
                            }
                        }
                    }
                }
            }
        }

        return $postsarray;
    }

    public function GetExploreHomePage($page, $userid)
    {
        $allposts = $this::orderby('created_at')->get();
        $allcommunities = community::where('userid', $userid)->get();
        $numberofpostsmax = $allposts->count();

        for ($x = 0; $x < $numberofpostsmax; $x++) {
            $unsetalready = false;
            foreach ($allcommunities as $community) {
                if (! $unsetalready && ! $allposts->IsEmpty()) {
                    if ($allposts[$x]->community == $community->community) {
                        unset($allposts[$x]);
                        $unsetalready = true;
                    }
                }
            }
        }

        $numberofpostsmax = $allposts->count();
        $postsarray = [];
        if ($numberofpostsmax != 0) {
            $x = 0;
            $tempallposts = $allposts;
            foreach ($tempallposts as $post) {
                $allposts[$x] = $post;
                $x++;
            }

            if ($numberofpostsmax == ($page - 1) * 10) {
                return [];
            } else {
                for ($x = (($page - 1) * 10); $x < $page * 10; $x++) {
                    if ($x < $numberofpostsmax) {
                        $username = user::where('userid', $allposts[$x]->userid)->first()->username;
                        $profilepic = user::where('userid', $allposts[$x]->userid)->first()->profilepic;
                        $voted = interaction::where('userid', $userid)->where('postid', $allposts[$x]->postid)->get();
                        $commentnumber = comment::where('postid', $allposts[$x]->postid)->get()->count();
                        if (! $voted->IsEmpty()) {
                            if ($voted[0]->liked == 1) {
                                $voted = 'upvote';
                            } else {
                                $voted = 'downvoted';
                            }
                        } else {
                            $voted = null;
                        }
                        $votes = $this->Votes($allposts[$x]->postid);
                        array_push($postsarray, ['postid' => $allposts[$x]->postid, 'head' => $allposts[$x]->head, 'body' => $allposts[$x]->body, 'username' => $username,
                            'profilepic' => $profilepic, 'picture' => $allposts[$x]->picture, 'votes' => $votes, 'voted' => $voted, 'community' => $allposts[$x]->community,
                            'created_at' => $allposts[$x]->created_at, 'commentsnumber' => $commentnumber, ]);
                    }
                }
            }

            return $postsarray;
        }

        return $postsarray;
    }

    public function ReturnPost($postid, $userid)
    {
        $post = $this::where('postid', $postid)->first();
        $votes = $this->Votes($postid);
        $username = user::where('userid', $post->userid)->first()->username;
        $profilepic = user::where('userid', $post->userid)->first()->profilepic;
        $commentnumber = comment::where('postid', $post->postid)->get()->count();

        $voted = interaction::where('userid', $userid)->where('postid', $postid)->get();
        if (! $voted->IsEmpty()) {
            if ($voted[0]->liked == 1) {
                $voted = 'upvote';
            } else {
                $voted = 'downvoted';
            }
        } else {
            $voted = null;
        }

        return ['postid' => $post->postid, 'head' => $post->head, 'body' => $post->body, 'picture' => $post->picture, 'username' => $username, 'profilepic' => $profilepic,
            'votes' => $votes, 'voted' => $voted, 'community' => $post->community, 'created_at' => $post->created_at, 'commentsnumber' => $commentnumber, ];
    }

    public function Votes($postid)
    {
        $upvotes = interaction::where('postid', $postid)->where('liked', 1)->get()->count();
        $downvotes = interaction::where('postid', $postid)->where('liked', 0)->get()->count();

        return $upvotes - $downvotes;
    }

    public function GetUserNewestPosts($username, $page)
    {
        $userid = user::where('username', $username)->first()->userid;
        $posts = $this::where('userid', $userid)->orderby('created_at', 'asc')->get();

        if ($posts->count() == ($page - 1) * 5) {
            return [];
        } else {
            $endarray = [];
            for ($x = ($page - 1) * 5; $x < ($page * 5); $x++) {
                if ($x < $posts->count()) {
                    $votes = $this->Votes($posts[$x]->postid);
                    $postuserid = $this::where('postid', $posts[$x]->postid)->first()->userid;
                    $username = user::where('userid', $postuserid)->first()->username;
                    $profilepic = user::where('userid', $postuserid)->first()->profilepic;
                    $voted = interaction::where('userid', $userid)->where('postid', $posts[$x]->commentid)->get();
                    $commentnumber = comment::where('postid', $posts[$x]->postid)->get()->count();
                    if (! $voted->IsEmpty()) {
                        if ($voted[0]->liked == 1) {
                            $voted = 'upvote';
                        } else {
                            $voted = 'downvoted';
                        }
                    } else {
                        $voted = null;
                    }

                    array_push($endarray,
                        ['postid' => $posts[$x]->postid,
                            'head' => $posts[$x]->head,
                            'body' => $posts[$x]->body,
                            'picture' => $posts[$x]->picture,
                            'votes' => $votes,
                            'created_at' => $posts[$x]->created_at,
                            'username' => $username,
                            'profilepic' => $profilepic,
                            'voted' => $voted,
                            'community' => $posts[$x]->community,
                            'commentsnumber' => $commentnumber, ]);
                }
            }
        }

        return $endarray;
    }

    public function GetUserLikedPosts($username, $page)
    {
        $userid = user::where('username', $username)->first()->userid;
        $posts = $this::where('userid', $userid)->orderby('created_at', 'asc')->get();

        if ($posts->count() == ($page - 1) * 5) {
            return [];
        } else {
            $endarray = [];

            foreach ($posts as $post) {
                $votes = $this->Votes($post->postid);
                $postuserid = $this::where('postid', $post->postid)->first()->userid;
                $username = user::where('userid', $postuserid)->first()->username;
                $profilepic = user::where('userid', $postuserid)->first()->profilepic;
                $voted = interaction::where('userid', $userid)->where('postid', $post->postid)->get();
                $commentnumber = comment::where('postid', $post->postid)->get()->count();
                if (! $voted->IsEmpty()) {
                    if ($voted[0]->liked == 1) {
                        $voted = 'upvote';
                    } else {
                        $voted = 'downvoted';
                    }
                } else {
                    $voted = null;
                }

                array_push($endarray,
                    ['postid' => $post->postid,
                        'head' => $post->head,
                        'body' => $post->body,
                        'picture' => $post->picture,
                        'votes' => $votes,
                        'created_at' => $post->created_at,
                        'username' => $username,
                        'profilepic' => $profilepic,
                        'voted' => $voted,
                        'community' => $post->community,
                        'commentsnumber' => $commentnumber, ]);

                $votes = array_column($endarray, 'votes');
                array_multisort($votes, SORT_DESC, $endarray);
            }
        }

        return $endarray;
    }

    public function GetCommunityNewestPosts($community, $userid, $page)
    {
        $posts = $this::where('community', $community)->orderby('created_at', 'asc')->get();

        if ($posts->count() == ($page - 1) * 10) {
            return [];
        } else {
            $endarray = [];
            for ($x = ($page - 1) * 10; $x < ($page * 10); $x++) {
                if ($x < $posts->count()) {
                    $votes = $this->Votes($posts[$x]->postid);
                    $postuserid = $this::where('postid', $posts[$x]->postid)->first()->userid;
                    $username = user::where('userid', $postuserid)->first()->username;
                    $profilepic = user::where('userid', $postuserid)->first()->profilepic;
                    $voted = interaction::where('userid', $userid)->where('postid', $posts[$x]->commentid)->get();
                    $commentnumber = comment::where('postid', $posts[$x]->postid)->get()->count();
                    if (! $voted->IsEmpty()) {
                        if ($voted[0]->liked == 1) {
                            $voted = 'upvote';
                        } else {
                            $voted = 'downvoted';
                        }
                    } else {
                        $voted = null;
                    }

                    array_push($endarray,
                        ['postid' => $posts[$x]->postid,
                            'head' => $posts[$x]->head,
                            'body' => $posts[$x]->body,
                            'picutre' => $posts[$x]->picture,
                            'votes' => $votes,
                            'created_at' => $posts[$x]->created_at,
                            'username' => $username,
                            'profilepic' => $profilepic,
                            'voted' => $voted,
                            'community' => $posts[$x]->community,
                            'commentsnumber' => $commentnumber, ]);
                }
            }
        }

        return $endarray;
    }

    public function GetCommunityLikedPosts($community, $userid, $page)
    {
        $posts = $this::where('community', $community)->orderby('created_at', 'asc')->get();

        if ($posts->count() == ($page - 1) * 5) {
            return [];
        } else {
            $endarray = [];

            foreach ($posts as $post) {
                $votes = $this->Votes($post->postid);
                $postuserid = $this::where('postid', $post->postid)->first()->userid;
                $username = user::where('userid', $postuserid)->first()->username;
                $profilepic = user::where('userid', $postuserid)->first()->profilepic;
                $voted = interaction::where('userid', $userid)->where('postid', $post->postid)->get();
                $commentnumber = comment::where('postid', $post->postid)->get()->count();
                if (! $voted->IsEmpty()) {
                    if ($voted[0]->liked == 1) {
                        $voted = 'upvote';
                    } else {
                        $voted = 'downvoted';
                    }
                } else {
                    $voted = null;
                }

                array_push($endarray,
                    ['postid' => $post->postid,
                        'head' => $post->head,
                        'body' => $post->body,
                        'picture' => $post->picture,
                        'votes' => $votes,
                        'created_at' => $post->created_at,
                        'username' => $username,
                        'profilepic' => $profilepic,
                        'voted' => $voted,
                        'community' => $post->community,
                        'commentsnumber' => $commentnumber, ]);

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

        if ($this::where('postid', $postid)->first()->userid == $userid || $authority == 'mod' || $authority == 'owner') {
            //Delete Comments
            $tobedeletedcomments = $comments::where('postid', $postid)->get();

            foreach ($tobedeletedcomments as $comment) {
                $comments->DeletedPost($comment->commentid);
            }

            //Delete Likes
            $interactions->DeleteLikesPost($postid);

            //Delete Post
            $this::where('postid', $postid)->delete();

            return ['Deleted' => true];
        }

        return ['Deleted' => false];
    }

    public function DeletePosts($postid) //When user deleted so multiple posts are deleted
    {
        $comments = new comment;
        $interactions = new interaction;

        //Delete Comments
        $tobedeletedcomments = comment::where('postid', $postid)->get();

        foreach ($tobedeletedcomments as $comment) {
            $comments->DeletedPost($comment->commentid);
        }

        //Delete Likes
        $interactions->DeleteLikesPost($postid);

        $this::where('postid', $postid)->delete();
    }
}
