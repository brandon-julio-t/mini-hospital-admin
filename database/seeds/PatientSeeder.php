<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patientsTable = DB::table('patients');
        $registrationFormsTable = DB::table('registration_forms');
        $receiptHeadersTable = DB::table('receipt_headers');
        $faker = Faker\Factory::create();

        $patientsTable->insert([
            'id' => 'PT001',
            'address' => $faker->address,
            'date_of_birth' => $faker->date(),
            'name' => $faker->name('male'),
            'phone_number' => $faker->numerify('08##########'),
            'sex' => 'male'
        ]);

        $registrationFormsTable->insert([
            'id' => 'F0001',
            'doctor_id' => 'DR001',
            'patient_id' => 'PT001',
            'staff_id' => 'ST001',
            'created_at' => Carbon\Carbon::now()
        ]);

        $receiptHeadersTable->insert([
            'id' => 'R0001',
            'registration_form_id' => 'F0001',
            'finalized_at' => null
        ]);
    }
}
