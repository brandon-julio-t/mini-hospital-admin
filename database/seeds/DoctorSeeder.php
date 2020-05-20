<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users');
        $doctors = DB::table('doctors');
        $faker = Faker\Factory::create();

        $users->insert([
            'id' => 'U0004',
            'username' => 'DR001',
            'password' => Hash::make('19700101')
        ]);

        $users->insert([
            'id' => 'U0005',
            'username' => 'DR002',
            'password' => Hash::make('19700101')
        ]);

        $doctors->insert([
            'id' => 'DR001',
            'user_id' => 'U0004',
            'address' => $faker->address,
            'date_of_birth' => '1970-01-01',
            'email' => $faker->email,
            'name' => 'Dr. ' . $faker->name,
            'phone_number' => $faker->numerify('02##########'),
            'salary' => $faker->numerify('#00000000'),
            'specialist' => 'Neurologist',
        ]);

        $doctors->insert([
            'id' => 'DR002',
            'user_id' => 'U0005',
            'address' => $faker->address,
            'date_of_birth' => '1970-01-01',
            'email' => $faker->email,
            'name' => 'Dr. ' . $faker->name,
            'phone_number' => $faker->numerify('02##########'),
            'salary' => $faker->numerify('#00000000'),
            'specialist' => 'Dermatologist',
        ]);
    }
}
