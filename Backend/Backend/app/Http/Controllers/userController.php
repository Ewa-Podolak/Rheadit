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
            
            Mail::to($email)
                ->send(new ResetPassword1($userid));

            return ['emailsent'=>true];
        }
        
    }

    public function ResetPassword($userid)
    {
        $password = request()->password;
        user::where('userid', $userid)->update(['password'=>$password]);
        return ['updated'=>true];
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

    public function Codewars()
    {
        $roman = 'MCMXC';
        $number = 0;
  
        $numbersignificance = ['I'=> 1, 'V'=>5, 'X'=>10, 'L'=>50, 'C'=>100, 'D'=>500, 'M'=>1000];
        $array = str_split($roman);
        
        for($i = 0; $i < count($array); $i++)
          {
          if($i == count($array)-1)
            $number += $numbersignificance[$array[$i]];
          else if($numbersignificance[$array[$i]] < $numbersignificance[$array[$i+1]])
            {
            $number += ($numbersignificance[$array[$i+1]] - $numbersignificance[$array[$i]]);
            $i++;
          }
          else
            $number += $numbersignificance[$array[$i]];
        }
        
        return $number;
        
    }
}
