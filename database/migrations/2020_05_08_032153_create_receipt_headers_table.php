<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_headers', function (Blueprint $table) {
            $table->char('id', 5)->primary();
            $table->char('registration_form_id', 5);
            $table->timestamp('finalized_at')->nullable();

            $table->foreign('registration_form_id')->references('id')->on('registration_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_headers');
    }
}
