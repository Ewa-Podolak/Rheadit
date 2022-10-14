<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword1;
use App\Models\user;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{
    public function CheckLogin($username, $password)
    {
        $user = new user;
        $info = $user->GetUserInfo($username, $password);
        if ($info) {
            return $this->ReturnInformation($info);
        } else {
            return ['userid' => null, 'username' => null];
        }
    }

    public function RegisterUser($username, $password, $email)
    {
        $user = new user;
        $info = $user->GetUserInfo($username, $password);
        if (! $info && $password != null && $email != null) {
            $user->CreateNewUser($username, $password, $email);
            $info = $user->GetUserInfo($username, $password);

            return $this->ReturnInformation($info);
        } else {
            return ['userid' => null, 'username' => null];
        }
    }

    public function SendEmail()
    {
        $email = request()->validate(['email' => 'required|email']);

        $userid = user::where('email', $email)->get();

        if ($userid->IsEmpty()) {
            return ['emailsent' => false];
        } else {
            $userid = $userid[0]->userid;

            Mail::to($email)
                ->send(new ResetPassword1($userid));

            return ['emailsent' => true];
        }
    }

    public function ResetPassword($userid)
    {
        $password = request()->password;
        user::where('userid', $userid)->update(['password' => $password]);

        return ['updated' => true];
    }

    public function DeleteUser($userid)
    {
        $user = new user;

        return $user->DeleteUser($userid);
    }

    public function UpdatePicture($userid)
    {
        $newpicture = request()->profilepic;
        user::where('userid', $userid)->update(['profilepic' => $newpicture]);

        return ['updated' => true];
    }

    public function UpdateBio($userid)
    {
        $newbio = request()->bio;
        user::where('userid', $userid)->update(['bio' => $newbio]);

        return ['updated' => true];
    }

    public function GetProfile($userid, $username)
    {
        $user = new user;

        return $user->GetProfile($userid, $username);
    }

    public function ReturnInformation($dbinfo)
    {
        return ['userid' => $dbinfo->userid, 'username' => $dbinfo->username];
    }

    public function SnailThingThatIamWayTooProudOf()
    {
        $array = [[1, 2, 3, 4],
            [5, 6, 7, 8],
            [9, 10, 11, 12],
            [13, 14, 15, 16], ];

        $size = count($array[0]);
        $minx = 0;
        $maxx = $size - 1;
        $miny = 0;
        $maxy = $size - 1;

        $endarray = [];

        if ($size == 0) {
            return null;
        } elseif ($size == 1) {
            return $array;
        }

        while (($minx <= $maxx) && ($miny <= $maxy)) {
            //Going Right //Works
            if (count($endarray) != $size * $size) {
                for ($y = $miny; $y <= $maxy; $y++) {
                    array_push($endarray, $array[$minx][$y]);
                }
                $minx++;
            }

            //Going Down
            if (count($endarray) != $size * $size) {
                for ($x = $minx; $x <= $maxx; $x++) {
                    array_push($endarray, $array[$x][$maxy]);
                }
                $maxy--;
            }

            //Going Left
            if (count($endarray) != $size * $size) {
                for ($y = $maxy; $y >= $miny; $y--) {
                    array_push($endarray, $array[$maxx][$y]);
                }
                $maxx--;
            }

            //Going Up
            if (count($endarray) != $size * $size) {
                for ($x = $maxx; $x >= $minx; $x--) {
                    array_push($endarray, $array[$x][$miny]);
                }
                $miny++;
            }
        }

        return $endarray;
    }

    public function CodeWars()
    {
    }
}
