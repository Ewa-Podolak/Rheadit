<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword1;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $email = request()->validate(['email' => 'required|email']); 

        $userid = user::where('email', $email)->get();

        if($userid->IsEmpty())
            return ['emailsent'=>false];

        else
        {
            $userid = $userid[0]->userid;
            
            ResetPassword1::to($email)
                ->send(new ResetPassword1());

            return ['emailsent'=>true];
        }
        
    }

    public function ResetPassword($userid)
    {
        $user = new user;
        $password = request()->password;
        return $user->SendEmail($password);
    }

    public function DeleteUser($userid)
    {
        $user = new user;
        return $user->DeleteUser($userid);
    }

    public function UpdatePicture($userid)
    {
        $newpicture = request()->profilepic;
        user::where('userid', $userid)->update(['profilepic'=>$newpicture]);
        return ['updated'=>true];
    }

    public function UpdateBio($userid)
    {
        $newbio = request()->bio;
        user ::where('userid', $userid)->update(['bio'=>$newbio]);
        return ['updated'=>true];
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
