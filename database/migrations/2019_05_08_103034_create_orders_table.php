<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('player_id');
			$table->foreign('player_id')->references('id')->on('users');
			
			$table->unsignedBigInteger('coach_id');
			$table->foreign('coach_id')->references('id')->on('users');
			
			$table->timestamp('booking_date');
			$table->decimal('amount',8,2)->default(0.0);
		
			$table->string('status',255)->nullable(); 
			$table->string('note',1024)->nullable();
			
			
			$table->time('slot_timing_start')->nullable();
			$table->time('slot_timing_end')->nullable();
			$table->unsignedInteger('ground_id')->nullable();
			$table->string('charge_id',255)->nullable();
			$table->string('account_id',255)->nullable();
			$table->string('card_id',255)->nullable();
			$table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
