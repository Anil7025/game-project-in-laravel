<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('likedto_userid')->references('id')->on('users');
			$table->unsignedBigInteger('likedby_userid')->references('id')->on('users');
			$table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_tables');
    }
}
