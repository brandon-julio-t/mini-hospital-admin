<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptDoctorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_doctor_details', function (Blueprint $table) {
            $table->char('receipt_id', 5);
            $table->char('doctor_charge_id', 5);

            $table->foreign('receipt_id')->references('id')->on('receipt_headers');
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
        Schema::dropIfExists('receipt_doctor_details');
    }
}
