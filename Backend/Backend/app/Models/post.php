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
                $upvotes = interaction::where('postid', $allposts[$x]->postid)->where('liked', 1)->get()->count();
                $downvotes = interaction::where('postid', $allposts[$x]->postid)->where('liked', 0)->get()->count();
                $votes = $upvotes-$downvotes;
                array_push($postsarray, ['postid'=>$allposts[$x]->postid, 'head'=>$allposts[$x]->title, 'username'=>$username, 'votes'=>$votes]);
            }
        return($postsarray);
    }








    public function DeleteUser($userid)
    {
        $this::where('userid', $userid)->get();
    }
}
