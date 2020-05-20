<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptMedicineDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_medicine_details', function (Blueprint $table) {
            $table->char('receipt_id', 5);
            $table->char('medicine_id', 5);
            $table->integer('quantity');

            $table->foreign('receipt_id')->references('id')->on('receipt_headers');
            $table->foreign('medicine_id')->references('id')->on('medicines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_medicine_details');
    }
}
