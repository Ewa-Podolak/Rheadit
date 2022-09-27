<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interaction extends Model
{
    use HasFactory;

    protected $table = 'interactions';
    public $timestamps = false;

    public function DeleteUser($userid)
    {
        $this::
            join('comments', 'interactions.commentid', '=', 'comments.commentid')
                ->join('posts', 'interactions.postid', '=', 'posts.postid')
                    ->join('posts', 'comments.postid', '=', 'posts.postid')
                        ->where('interactions.userid', $userid)
                            ->orwhere('comments.userid', $userid)
                                ->orwhere('posts.userid', $userid)
                                    ->delete();
    }
}
