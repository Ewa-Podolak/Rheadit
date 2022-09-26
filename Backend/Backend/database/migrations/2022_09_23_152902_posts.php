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
            $table->string('title', 30);
            $table->string('body', 150)->nullable()->default(NULL);
            $table->string('Community', 30)->nullable()->default(NULL);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::drop('posts');
    }
};
