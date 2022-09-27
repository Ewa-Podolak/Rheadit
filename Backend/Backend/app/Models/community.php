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
        $owner = $this::where('community', $community)->where('userid', $userid);

        if(!$owner->get()->IsEmpty())
        {
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
}