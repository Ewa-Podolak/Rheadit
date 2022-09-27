<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Symfony\Component\HttpFoundation\count;

class post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    public $timestamps = false;

    public function GetHomePage($page)
    {
        $allposts = user::asc('timestamps')->get();
        $numberofpostsmax = $allposts.count();
        if($numberofpostsmax == $page * 10)
        for($x = ($page * 10) - 1; $x < $numberofpostsmax; $x++)
        {

        }
    }








    public function DeleteUser($userid)
    {
        $this::where('userid', $userid)->get();
    }
}
