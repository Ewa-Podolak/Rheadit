<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use App\Models\user;

class userController extends Controller
{
    public function CheckLogin($username, $password)
    {
        $user = new user;
        $info = $user->GetUserInfo($username, $password);
        if($info)
            return $this->ReturnInformation($info);
        else
            return ['userid' => null, 'username' => null];
    }

    public function RegisterUser($username, $password, $email)
    {
        $user = new user;
        $info = $user->GetUserInfo($username, $password);
        if(!$info)
        {
            $user->CreateNewUser($username, $password, $email);;
            return $this->ReturnInformation($info);
        }
        else
            return ['userid' => null, 'username' => null];
    }

    public function SendEmail($email)
    {

    }

    public function ResetPassword($password)
    {
        
    }

    public function DeleteUser($userid)
    {
        $user = new user;
        $user->DeleteUser($userid);
        return ['status' => true];
    }

    public function GetProfile($userid)
    {
        $user = new user;
        $userprofile = $user->GetProfile($userid);
        return $userprofile;
    }

    public function ReturnInformation($dbinfo)
    {
        return ['userid'=> $dbinfo->userid, 'username' => $dbinfo->username];
    }
}
