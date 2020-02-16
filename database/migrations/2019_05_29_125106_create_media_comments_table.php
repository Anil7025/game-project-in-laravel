<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('media_id')->references('id')->on('media');
			$table->unsignedBigInteger('mediapostedby_userid')->references('id')->on('users');
			$table->unsignedBigInteger('commentedby_userid')->references('id')->on('users');
			$table->string('comment',1024)->nullable();
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
        Schema::dropIfExists('media_comments');
    }
}
