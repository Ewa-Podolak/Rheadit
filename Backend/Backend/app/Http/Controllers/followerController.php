<?php

namespace App\Http\Controllers;

use App\Models\follower;
use App\Models\user;

class followerController extends Controller
{
    public function GetFollowersList($username)
    {
        $userid = user::where('username', $username)->first()->userid;

        return follower::join('users', 'followers.follower', '=', 'users.userid')->where('followers.user', $userid)->get('users.username');
    }

    public function GetFollowedList($username)
    {
        $userid = user::where('username', $username)->first()->userid;

        return follower::join('users', 'followers.user', '=', 'users.userid')->where('followers.follower', $userid)->get('users.username');
    }

    public function Follow($userid, $username)
    {
        $usernameid = user::where('username', $username)->first()->userid;
        $follow = follower::where('user', $usernameid)->where('follower', $userid)->get();
        if ($follow->IsEmpty()) {
            follower::insert(['user' => $usernameid, 'follower' => $userid]);
        } else {
            follower::where('user', $usernameid)->where('follower', $userid)->delete();
        }

        return ['followed' => true];
    }
}
