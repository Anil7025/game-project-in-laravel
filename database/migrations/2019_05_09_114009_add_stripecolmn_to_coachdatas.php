<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripecolmnToCoachdatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coachdatas', function (Blueprint $table) {
            $table->string('stripecustomer_id',255)->nulable();
			$table->text('stripe_log_data')->nullable();
			$table->text('stripe_custom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coachdatas', function (Blueprint $table) {
            //
        });
    }
}
