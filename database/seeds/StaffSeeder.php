<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users');
        $staffs = DB::table('staffs');
        $faker = Faker\Factory::create();

        $users->insert([
            'id' => 'U0002',
            'username' => 'ST001',
            'password' => Hash::make('19700101')
        ]);

        $users->insert([
            'id' => 'U0003',
            'username' => 'ST002',
            'password' => Hash::make('19700101')
        ]);

        $staffs->insert([
            'id' => 'ST001',
            'user_id' => 'U0002',
            'address' => $faker->address,
            'date_of_birth' => '1970-01-01',
            'name' => 'Adam',
            'phone_number' => $faker->numerify('02##########'),
            'role' => 'Cashier',
            'salary' => $faker->numerify('#000000'),
        ]);

        $staffs->insert([
            'id' => 'ST002',
            'user_id' => 'U0003',
            'address' => $faker->address,
            'date_of_birth' => '1970-01-01',
            'name' => 'Eve',
            'phone_number' => $faker->numerify('02##########'),
            'role' => 'Cashier',
            'salary' => $faker->numerify('#000000'),
        ]);
    }
}
