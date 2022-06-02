<?php

declare (strict_types = 1);
use Illuminate\Database\Seeder;
use \App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['slug' => 'administrator'],
            ['name' => __('Administrator'),
            'description' => '',
        ]);
        
        Role::firstOrCreate(['slug' => 'graduate'],
            ['name' => __('Graduate'),
            'description' => '',
        ]);
        
    }
}
