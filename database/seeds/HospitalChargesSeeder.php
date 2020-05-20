<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalChargesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('hospital_charges');

        $table->insert([
            'id' => 'HC001',
            'name' => 'Registration Fee',
            'amount' => 30000
        ]);

        $table->insert([
            'id' => 'HC002',
            'name' => 'Laboratory Services',
            'amount' => 1000000
        ]);

        $table->insert([
            'id' => 'HC003',
            'name' => 'Medication/Pharmacy Charges',
            'amount' => 700000
        ]);
    }
}
