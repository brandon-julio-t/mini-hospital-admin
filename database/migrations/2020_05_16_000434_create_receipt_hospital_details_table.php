<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptHospitalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_hospital_details', function (Blueprint $table) {
            $table->char('receipt_id', 5);
            $table->char('hospital_charge_id', 5);

            $table->foreign('receipt_id')->references('id')->on('receipt_headers');
            $table->foreign('hospital_charge_id')->references('id')->on('hospital_charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_hospital_details');
    }
}
