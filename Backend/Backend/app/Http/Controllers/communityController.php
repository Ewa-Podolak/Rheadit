<?php

namespace App\Http\Controllers;

use App\Models\community;
use Illuminate\Http\Request;

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
}
