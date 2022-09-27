<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table)
        {
            $table->increments('postid');
            $table->integer('userid');
            $table->string('title', 30);
            $table->string('body', 150)->nullable()->default(NULL);
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('favourited')->nullable()->default(false);
        });
    }

    public function down()
    {
        Schema::drop('comments');
    }
};
