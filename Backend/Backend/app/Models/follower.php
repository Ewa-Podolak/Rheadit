<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class follower extends Model
{
    use HasFactory;

    protected $table = 'followers';
    public $timestamps = false;
    
    public function GetFollowersList($username)
    {

    }
   
    public function GetFollowedList($username)
    {
        
    }
}
