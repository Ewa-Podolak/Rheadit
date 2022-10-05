<?php

namespace App\Http\Controllers;

use App\Models\community;
use App\Models\user;

class communityController extends Controller
{
    public function JoinCommunity($communityname, $userid)
    {
        $owner = community::where('community', $communityname)->where('userid', $userid);
        if($owner->get()->IsEmpty())
        {
            community::insert(['userid'=>$userid, 'community'=>$communityname, 'authority'=>'member']);
            return ['joined'=>true];
        }
        return ['joined'=>false];
    }

    public function LeaveCommunity($communityname, $userid)
    {
        $community = new community;
        return $community->LeaveCommunity($communityname, $userid);
    }

    public function TransferOwnership($communityname, $userid, $newowner)
    {
        if(community::where('community', $communityname)->where('userid', $userid)->get()[0]->authority == 'owner')
        {
            community::where('community', $communityname)->where('userid', $userid)->update(['userid'=>$newowner]);
            return ['transfered'=>true];
        }
        return ['transfered'=>false];
    }

    public function DeleteCommunity($communityname, $userid)
    {
        $community = new community;
        return $community->DeleteCommunity($communityname, $userid);
    }

    public function GetCommunity($communityname, $userid)
    {
        $community = new community;
        return $community->GetCommunity($communityname, $userid);
    }

    public function RequestMod($communityname, $userid)
    {
        $community = new community;
        return $community->RequestMod($communityname, $userid);
    }

    public function ApproveMod($communityname, $userid, $username)
    {
        $community = new community;
        return $community->ApproveMod($communityname, $userid, $username);
    }

    public function UpdateCommunityBio($communityname, $userid)
    {
        if(community::where('userid', $userid)->where('community', $communityname)->first()->authority == 'owner')
        {
            user::where('username', $communityname)->update(['bio'=>request()->bio]);
            return ['updated'=>true];
        }
        return ['updated'=>false];
    }

    public function UpdateCommunityPic($communityname, $userid)
    {
        if(community::where('userid', $userid)->where('community', $communityname)->first()->authority == 'owner')
        {
            user::where('username', $communityname)->update(['profilepic'=>request()->profilepic]);
            return ['updated'=>true];
        }
        return ['updated'=>false];
    }

    public function OwnerRequestNotifications($userid)
    {
       $communities = community::where('userid', $userid)->where('authority', 'owner')->get();

       $requests = community::where('requestmod', true)->get();

       $requestsarray = [];

        if($requests->IsEmpty())
            return ['username'=>null, 'community'=>null];
        else
        {
            foreach($communities as $community)
            {
                foreach($requests as $request)
                {
                    if($request->community == $community->community)
                    {
                        $username = user::where('userid', $request->userid)->first()->username;
                        array_push($requestsarray, ['username'=>$username, 'community'=>$community->community]);
                    }
                }
            }
        }
        return $requestsarray;
    }
}
