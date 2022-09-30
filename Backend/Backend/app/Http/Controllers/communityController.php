<?php

namespace App\Http\Controllers;

use App\Models\community;

class communityController extends Controller
{
    public function JoinCommunity($communityname, $userid)
    {
        $community = new community();
        return $community->JoinCommunity($communityname, $userid);
    }

    public function LeaveCommunity($communityname, $userid)
    {
        $community = new community;
        return $community->LeaveCommunity($communityname, $userid);
    }

    public function TransferOwnership($communityname, $userid, $newowner)
    {
        $community = new community;
        return $community->TransferOwnership($communityname, $userid, $newowner);
    }

    public function DeleteComunity($communityname, $userid)
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
}
