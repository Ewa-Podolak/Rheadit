<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('interactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->integer('commentid')->nullable();
            $table->integer('postid')->nullable();
            $table->boolean('liked'); //0 = downvote, 1 = upvote
        });
    }

    public function down()
    {
        Schema::drop('interactions');
    }
};
