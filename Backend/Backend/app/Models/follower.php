<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class follower extends Model
{
    use HasFactory;

    protected $table = 'followers';
    public $timestamps = false;

    public function DeleteUser($userid)
    {
        $this::where('user', $userid)->orwhere('follower', $userid)->delete();
    }
}
