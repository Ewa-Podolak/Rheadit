<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table)
        {
            $table->increments('postid');
            $table->integer('userid');
            $table->string('head', 75);
            $table->string('body', 255)->nullable()->default(NULL);
            $table->string('picture', 255)->nullable()->default(NULL);
            $table->string('community', 30)->nullable()->default(NULL);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::drop('posts');
    }
};
