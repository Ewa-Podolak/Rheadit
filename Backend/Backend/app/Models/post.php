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
                array_push($postsarray, ['postid'=>$allposts[$x]->postid, 'head'=>$allposts[$x]->title, 'username'=>$username, 'votes'=>$votes]);
            }
        return($postsarray);
    }

    public function ReturnPost($postid)
    {
        $post = $this::where('postid', $postid)->first();
        $votes = $this->Votes($postid);
        $username = user::where('userid', $post->userid)->first()->username; 

        return ['head'=>$post->title, 'tails'=>$post->body, 'upvotes'=> $votes, 'username'=>$username, 'community'=>$post->title];
    }

    public function Votes($postid)
    {
        $upvotes = interaction::where('postid', $postid)->where('liked', 1)->get()->count();
        $downvotes = interaction::where('postid', $postid)->where('liked', 0)->get()->count();
        return $upvotes-$downvotes;
    }
}
