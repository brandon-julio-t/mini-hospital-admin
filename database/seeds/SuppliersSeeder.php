<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('suppliers');
        $faker = Faker\Factory::create();

        for ($id = 1; $id <= 5; $id++) {
            $table->insert([
                'id' => 'SU00' . $id,
                'address' => $faker->address,
                'email' => $faker->companyEmail,
                'name' => $faker->lastName . ' Pharmacy',
                'phone_number' => $faker->numerify('02##########'),
            ]);
        }
    }
}
