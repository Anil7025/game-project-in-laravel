<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coachdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('user_id')->references('id')->on('users'); 
			$table->string('profile',255)->nullable();
			$table->string('about_me',1024)->nullable();
			$table->string('accomplishment',1024)->nullable(); 
			
			$table->string('experience',1024)->nullable();
			
			$table->string('qualification',1024)->nullable();
			
			$table->decimal('price_per_hour',8,2)->default(0.0);
			$table->string('address',1024)->nullable();
			$table->string('pitch',1024)->nullable();
			$table->string('travel',1024)->nullable();
			$table->string('doccument',255)->nullable();
			$table->string('step_check',255)->nullable();
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
        Schema::dropIfExists('coachdatas');
    }
}
