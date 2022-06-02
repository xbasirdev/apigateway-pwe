<?php

declare (strict_types = 1);

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ])->assignRole("administrator");
        
        User::firstOrCreate(['email' => 'graduate@gmail.com'], [
            'name' => 'graduate',
            'email' => 'graduate@gmail.com',
            'password' => Hash::make('123456'),
        ])->assignRole("graduate");
    }
}
