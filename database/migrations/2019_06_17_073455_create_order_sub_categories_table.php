<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('order_id');
			$table->foreign('order_id')->references('id')->on('orders');
			
			$table->timestamp('booking_date');
			$table->decimal('amount',8,2)->default(0.0);
		
			$table->string('status',255)->nullable();
			
			$table->time('slot_timing_start')->nullable();
			$table->time('slot_timing_end')->nullable();
			$table->unsignedBigInteger('coach_id');
			$table->unsignedBigInteger('player_id');
			$table->unsignedBigInteger('pitch_id');
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
        Schema::dropIfExists('order_sub_categories');
    }
}
