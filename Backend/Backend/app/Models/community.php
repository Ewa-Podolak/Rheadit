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

        $userrole = $this::where('community', $communityname)->where('userid', $userid)->first()->authority;

        return ['communityname'=>$communityname, 
                'ownername'=>$ownername, 
                'modnumber'=>$modnumber, 
                'memebernumber'=>$membernumber, 
                'profilepic'=>$profileinfo->profilepic, 
                'bio'=>$profileinfo->bio, 
                'userrole'=>$userrole];
    }
}