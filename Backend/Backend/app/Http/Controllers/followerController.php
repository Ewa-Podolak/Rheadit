<?php

namespace App\Http\Controllers;

use App\Models\follower;

class followerController extends Controller
{
    public function GetFollowersList($username)
    {
        $follower = new follower;
        return $follower->GetFollowersList($username);
    }

    public function GetFollowedList($username)
    {
        $follower = new follower;
        return $follower->GetFollowedList($username);
    }
}