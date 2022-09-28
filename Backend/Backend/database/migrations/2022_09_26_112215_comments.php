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
            $table->increments(('commentid'));
            $table->integer('postid');
            $table->integer('userid');
            $table->string('comment', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('favourited')->nullable()->default(false);
        });
    }

    public function down()
    {
        Schema::drop('comments');
    }
};
