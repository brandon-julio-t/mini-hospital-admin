<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('medicines');

        $table->insert([
            'id' => 'MD001',
            'supplier_id' => 'SU001',
            'disease' => 'Headache',
            'name' => 'Paracetamol',
            'type' => 'Internal'
        ]);

        $table->insert([
            'id' => 'MD002',
            'supplier_id' => 'SU002',
            'disease' => 'Infection',
            'name' => 'Betadine',
            'type' => 'External'
        ]);

        $table->insert([
            'id' => 'MD003',
            'supplier_id' => 'SU003',
            'disease' => 'Diarrhea',
            'name' => 'Entrostop',
            'type' => 'Internal'
        ]);

        $table->insert([
            'id' => 'MD004',
            'supplier_id' => 'SU004',
            'disease' => 'Mag',
            'name' => 'Mylanta',
            'type' => 'Internal'
        ]);

        $table->insert([
            'id' => 'MD005',
            'supplier_id' => 'SU005',
            'disease' => 'Diabetes',
            'name' => 'Insulin',
            'type' => 'Internal'
        ]);
    }
}
