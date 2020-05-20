<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            DoctorChargesSeeder::class,
            DoctorSeeder::class,
            HospitalChargesSeeder::class,
            StaffSeeder::class,
            SuppliersSeeder::class,

            /* last */
            MedicineSeeder::class,
            PatientSeeder::class,
        ]);
    }
}
