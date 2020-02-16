<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('user_id')->references('id')->on('users');
			$table->string('message',1024)->nullable();
			
			$table->string('images',1024)->nullable();
			$table->string('type',50)->nullable();
			$table->string('uploaded_user',50)->nullable();
			$table->boolean('status')->default(1);
			$table->unsignedInteger('total_like')->default(0);
			$table->unsignedInteger('total_comment')->default(0);
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
        Schema::dropIfExists('media');
    }
}
