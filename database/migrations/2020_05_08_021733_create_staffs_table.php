<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->char('id', 5)->primary();
            $table->char('user_id', 5);
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('name', 50);
            $table->char('phone_number', 12);
            $table->string('role', 25);
            $table->decimal('salary', 15, 2);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
}
