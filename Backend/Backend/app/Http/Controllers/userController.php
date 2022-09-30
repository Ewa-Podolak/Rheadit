<?php

namespace App\Http\Controllers;

use App\Models\user;
use GuzzleHttp\Psr7\Request;

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
        if(!$info && $password != null && $email != null)
        {
            $user->CreateNewUser($username, $password, $email);
            $info = $user->GetUserInfo($username, $password);
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
        return $user->DeleteUser($userid);
    }

    public function UpdatePicture($userid, Request $request)
    {
        $user = new user;
        $newpicture = $request()->json()->profilepic;
        dd($newpicture);
        return $user->UpdatePicture($userid, $newpicture);
    }

    public function UpdateBio($userid, $bio)
    {
        $user = new user;
        return $user->UpdateBio($userid, $bio);
    }

    public function GetProfile($userid, $username)
    {
        $user = new user;
        return $user->GetProfile($userid, $username);
    }

    public function ReturnInformation($dbinfo)
    {
        return ['userid'=> $dbinfo->userid, 'username' => $dbinfo->username];
    }
}
