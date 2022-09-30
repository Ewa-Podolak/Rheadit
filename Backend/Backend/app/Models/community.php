<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class community extends Model
{
    use HasFactory;

    protected $table = 'community';
    public $timestamps = false;

    public function JoinCommunity($community, $userid)
    {
        $owner = $this::where('community', $community)->where('userid', $userid);
        if($owner->get()->IsEmpty())
        {
            $this::insert(['userid'=>$userid, 'community'=>$community, 'authority'=>'member']);
            return ['joined'=>true];
        }
        return ['joined'=>false];
    }

    public function LeaveCommunity($community, $userid)
    {
        $post = new post;

        $owner = $this::where('community', $community)->where('userid', $userid);

        if(!$owner->get()->IsEmpty())
        {
            $allposts = post::where('userid', $userid)->where('community', $community)->get();

            foreach($allposts as $post)
                $post->DeletePosts($post->postid);

            $owner->delete();
            return ['left'=>true];
        }
        return ['left'=>false];
    }

    public function TransferOwnership($community, $userid, $newowner)
    {
        if($this::where('community', $community)->where('userid', $userid)->get()[0]->authority == 'owner')
        {
            $this::where('community', $community)->where('userid', $userid)->update(['userid'=>$newowner]);
            return ['transfered'=>true];
        }
        return ['transfered'=>false];
    }

    public function DeleteCommunity($community, $userid)
    {
        if($this::where('userid', $userid)->where('community', $community)->first()->authority == 'owner')
        {
            $allusers = $this::where('community', $community)->get();

            foreach($allusers as $user)
                $this->LeaveCommunity($community, $user->userid);

            user::where('username', $community)->delete();
            return ['deleted'=>true];
        }
        return ['deleted'=>false];
    }

    public function GetCommunity($communityname, $userid)
    {
        $profileinfo = user::where('username', $communityname)->first();

        $ownerid = $this::where('community', $communityname)->where('authority', 'owner')->first()->userid;
        $ownername = user::where('userid', $ownerid);

        $modnumber = $this::where('community', $communityname)->where('authority', 'mod')->get()->count();
        $membernumber = $this::where('community', $communityname)->get()->count();

        $userrole = $this::where('community', $communityname)->where('userid', $userid)->get();
        if($userrole->IsEmpty())
            $userrole = null;
        else
            $userrole = $userrole[0]->authority;

        return ['communityname'=>$communityname, 
                'ownername'=>$ownername, 
                'modnumber'=>$modnumber, 
                'memebernumber'=>$membernumber, 
                'profilepic'=>$profileinfo->profilepic, 
                'bio'=>$profileinfo->bio, 
                'userrole'=>$userrole];
    }

    public function RequestMod($community, $userid)
    {
        $info = $this::where('community', $community)->where('userid', $userid);
        if(!$info->get()->IsEmpty())
        {
            if($info->first()->authority=='member')
            {
                if($info->first()->requestmod==false)
                {
                    $info->update(['requestmod'=>true]);
                    return ['request'=>true];
                }
                else
                {
                    $info->update(['requestmod'=>false]);
                    return ['request'=>true];
                }
            }
        }
        return ['request'=>false];
    }

    public function ApproveMod($community, $userid, $username)
    {
        $authority = $this::where('community', $community)->where('userid', $userid)->first()->authority;
        if($authority=='owner'||$authority=='mod')
        {
            $usernameid = user::where('username', $username)->first()->userid;
            $this::where('community', $community)->where('userid', $usernameid)->update(['authority'=>'mod', 'requestmod'=>0]);
            return ['approved'=>true];
        }
        return ['approved'=>false];
    }
}