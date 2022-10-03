<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;

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

    public function SendEmail()
    {
        $user = new user;
        $email = request()->email;
        return $user->SendEmail($email);
    }

    public function ResetPassword($password)
    {
        
    }

    public function DeleteUser($userid)
    {
        $user = new user;
        return $user->DeleteUser($userid);
    }

    public function UpdatePicture($userid)
    {
        $user = new user;
        $newpicture = request()->profilepic;
        return $user->UpdatePicture($userid, $newpicture);
    }

    public function UpdateBio($userid)
    {
        $user = new user;
        $bio = request()->bio;
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
