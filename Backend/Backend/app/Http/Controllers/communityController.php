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
}
