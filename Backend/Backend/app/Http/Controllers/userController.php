<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;

class userController extends Controller
{
    public function CheckLogin($username, $password)
    {
        $user = new user;
        $info = $user->GetUserInfo($username, $password);
        if($info)
            return ['loggedin' => true];
            //return $this->ReturnInformation($info);
        else
            return ['loggedin' => false];
    }

    public function RegisterUser($username, $password, $email)
    {
        $user = new user;
        $info = $user->GetUserInfo($username, $password);
        if(!$info)
        {
            $user->CreateNewUser($username, $password, $email);
            return ['usercreated' => true];
            //return $this->ReturnInformation($info);
        }
        else
            return ['usercreated' => false];
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
        
    }
}
