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
    }

    public function GetProfile($username)
    {
        $user = $this::where('username', $username)->get();
        $followers = follower::where('user', $user[0]->userid)->get()->count();
        $following = follower::where('follower', $user[0]->userid)->get()->count();

        return ['username'=>$user[0]->username, 'bio'=>$user[0]->bio, 'profilepic'=>$user[0]->profilepic, 'followers'=>$following, 'following'=>$followers];
    }

    public function UpdatePicture($userid, $newpicture)
    {
        $this::where('userid', $userid)->update(['profilepic'=>$newpicture]);
        return ['updated'=>true];
    }

    public function UpdateBio($userid, $newbio)
    {
        $this::where('userid', $userid)->update(['bio'=>$newbio]);
        return ['updated'=>true];
    }

    public function DeleteUser($userid)
    {
        $community = new community;

        $alljoinedcommunities = community::where('userid', $userid)->get();

        foreach($alljoinedcommunities as $community)
            $community->LeaveComunity($community->community, $userid);
        
        follower::where('user', $userid)->orwhere('follower', $userid)->delete();

        $this::where('userid', $userid)->delete();

        return ['deleted'=>true];
    }
}
