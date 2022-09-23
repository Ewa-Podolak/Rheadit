<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;

class userController extends Controller
{
    public function CheckLogin($username, $password)
    {
        $info = user->GetUserInfo($username, $password);
        if(!$info->IsEmpty())
            return ['loggedin' => true];
            //return $this->ReturnInformation($info);
        else
            return ['loggedin' => false];
    }

    public function RegisterUser($username, $password, $email)
    {
        $info = user->GetUserInfo($username, $password);
        if($info->IsEmpty())
        {
            user->CreateUser($username, $password, $email);
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
        user->DeleteUser($userid);
    }

    public function ReturnInformation($dbinfo)
    {

    }
}
