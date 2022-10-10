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
    public $emaillink;

    public function __construct($_userid)
    {
        //$this->emaillink = "http://localhost:8000/api/users/resetpassword/" . $_userid;
        $this->emaillink = "http://127.0.0.1:5555/resetpassword.html?userid=". $_userid;
    }

    public function build()
    {
        return $this->view('resetpassword')
            ->subject('Reset Password');
    }
}
