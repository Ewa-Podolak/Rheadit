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
        $userid = user::where('username', $username)->first()->userid;
        return $this::join('users', 'followers.follower','=','users.userid')->where('followers.user', $userid)->get('users.username');
    }
   
    public function GetFollowedList($username)
    {
        $userid = user::where('username', $username)->first()->userid;
        return $this::join('users', 'followers.user','=','users.userid')->where('followers.follower', $userid)->get('users.username');
    }

    public function Follow($userid, $username)
    {
        $usernameid = user::where('username', $username)->first()->userid;
        $follow = $this::where('user', $usernameid)->where('follower', $userid)->get();
        if($follow->IsEmpty())
            $this::insert(['user'=>$usernameid, 'follower'=>$userid]);
        else
            $this::where('user', $usernameid)->where('follower', $userid)->delete();
        
        return ['followed'=>true];
    }
}
