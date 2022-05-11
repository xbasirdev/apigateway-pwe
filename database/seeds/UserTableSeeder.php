<?php

declare (strict_types = 1);

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::firstOrCreate(['email' => 'user1@gmail.com'], [
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
