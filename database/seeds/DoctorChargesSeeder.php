<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorChargesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('doctor_charges');

        $table->insert([
            'id' => 'DC001',
            'name' => 'Consult Fee',
            'amount' => 300000,
        ]);

        $table->insert([
            'id' => 'DC002',
            'name' => 'Action Fee',
            'amount' => 500000,
        ]);

        $table->insert([
            'id' => 'DC003',
            'name' => 'Operation Fee',
            'amount' => 1000000,
        ]);
    }
}
