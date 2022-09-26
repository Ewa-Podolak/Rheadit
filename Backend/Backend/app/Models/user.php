<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;

    public function GetUserInfo($username, $password)
    {
        $info = $this::where('username', $username)->where('password', $password)->first();
        return $info;
    }

    public function CreateNewUser($username, $password, $email)
    {
        $this::insert(['username' => $username, 'password' => $password, 'email' => $email]);
    }

    public function DeleteUser($userid)
    {
        $this::where('userid', $userid)->delete();
    }
}
