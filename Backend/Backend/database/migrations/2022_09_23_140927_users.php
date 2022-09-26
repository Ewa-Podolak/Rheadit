<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->increments('userid');
            $table->string('username', 12);
            $table->string('password', 72);
            $table->string('email');
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
};
