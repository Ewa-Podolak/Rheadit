<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    public $timestamps = false;

    public function DeleteUser($userid)
    {
        $this::
            join('posts', 'comments.postid', '=', 'posts.postid')
                ->where('comments.userid', $userid)
                    ->orwhere('posts.userid', $userid)
                        ->delete();
    }
}
