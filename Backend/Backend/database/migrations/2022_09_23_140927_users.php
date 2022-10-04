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
            $table->string('password', 72)->nullable();
            $table->string('email')->nullable();
            $table->string('profilepic')->nullable()->default(Null);
            $table->string('bio')->nullable()->default(Null);
            $table->string('resetpasswordtoken', 255)->nullable()->default(NULL);
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
};
