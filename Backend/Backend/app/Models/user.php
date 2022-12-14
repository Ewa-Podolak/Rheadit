<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;

    protected $table = 'users';

    public $timestamps = false;

    public function GetUserInfo($username, $password)
    {
        $info = $this::where('username', $username)->where('password', $password)->first();

        return $info;
    }

    public function CreateNewUser($username, $password, $email)
    {
        $this::insert(['username' => $username, 'password' => $password, 'email' => $email]);
        $userid = $this::where('username', $username)->first()->userid;
        community::insert(['userid' => $userid, 'community' => 'homepage', 'authority' => 'member']);
    }

    public function GetProfile($userid, $username)
    {
        $user = $this::where('username', $username)->get();
        $followers = follower::where('user', $user[0]->userid)->get()->count();
        $following = follower::where('follower', $user[0]->userid)->get()->count();
        if (follower::where('follower', $userid)->get()->IsEmpty()) {
            $followed = false;
        } else {
            $followed = true;
        }

        return ['username' => $user[0]->username, 'bio' => $user[0]->bio, 'profilepic' => $user[0]->profilepic, 'followers' => $followers, 'following' => $following, 'followed' => $followed];
    }

    public function DeleteUser($userid)
    {
        $community = new community;

        $alljoinedcommunities = community::where('userid', $userid)->get();

        foreach ($alljoinedcommunities as $communityname) {
            $community->LeaveCommunity($communityname->community, $userid);
        }

        follower::where('user', $userid)->orwhere('follower', $userid)->delete();

        interaction::where('userid', $userid)->delete();

        $this::where('userid', $userid)->delete();

        return ['deleted' => true];
    }
}
