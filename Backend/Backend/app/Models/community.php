<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class community extends Model
{
    use HasFactory;

    protected $table = 'community';
    public $timestamps = false;

    public function LeaveCommunity($community, $userid)
    {
        $post = new post;
        $comment = new comment;
        $user = $this::where('community', $community)->where('userid', $userid);

        if(!$user->get()->IsEmpty())
        {
            if($user->get()[0]->authority != 'owner')
            {
                $allposts = post::where('userid', $userid)->where('community', $community)->get();
                foreach($allposts as $posts)
                    $post->DeletePosts($posts->postid);
            
                $allcomments = comment::where('userid', $userid)->get();
                foreach($allcomments as $comment)
                    $comment->DeletedComment($comment->commentid, $userid);

                $user->delete();
                return ['left'=>true];
            }
        }
        return ['left'=>false];
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

    public function JoinableComunity($userid)
    {
        $joinedcommunities = $this::where('userid', $userid)->get();
        $allcommunities = $this::where('authority', 'owner')->wherenot('userid', $userid)->get();
        $joinablecommunities = [];

        foreach($joinedcommunities as $joinedcommunity)
        {
            foreach($allcommunities as $community)
            {
                if($joinedcommunity->community != $community->community)
                {
                    $membernumber = $this::where('community', $community->community)->get()->count();
                    array_push($joinablecommunities, ['communityname'=>$community->community, 'membersnumber'=>$membernumber]);
                }
            }
        }
        if($joinablecommunities == [])
        {
            $joinablecommunities = ['communityname'=>null, 'membersnumber'=>null];
        }

        return $joinablecommunities;
    }
}