<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_details', function (Blueprint $table) {
            $table->char('hospital_charge_id', 5);
            $table->char('medicine_id', 5);
            $table->char('doctor_charge_id', 5);

            $table->foreign('hospital_charge_id')->references('id')->on('hospital_charges');
            $table->foreign('medicine_id')->references('id')->on('medicines');
            $table->foreign('doctor_charge_id')->references('id')->on('doctor_charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_details');
    }
}
