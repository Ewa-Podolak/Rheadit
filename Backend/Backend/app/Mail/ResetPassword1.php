<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ResetPassword1 extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {

    }

    public function build()
    {
        $userid = 1;
        $emaillink = "http://localhost:8000/api/users/resetpassword/" . $userid;
        return $this->view('resetpassword', ['emaillink' => $emaillink]);
    }
}
