<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class posttests extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function correctuserlogin()
    {
        $response = $this->get('/users/login/Ewa/Potato');

        $response->dd();
    }
}
