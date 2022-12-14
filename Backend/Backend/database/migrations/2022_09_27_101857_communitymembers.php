<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('community', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->string('community', 30);
            $table->string('authority', 6);
            $table->boolean('requestmod')->default(false);
        });
    }

    public function down()
    {
        Schema::drop('community');
    }
};
