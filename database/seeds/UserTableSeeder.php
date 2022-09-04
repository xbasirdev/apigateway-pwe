<?php

declare (strict_types = 1);

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\UserService;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_service = new userService;
        $user_service->createUser([
            'nombres' =>"admin",
            'apellidos' =>"admin",
            'cedula' =>"11111111",
            'telefono' =>"11111111",
            "correo"=>"admin@gmail.com",
            'es_administrador'=>true,
            "modo_registro"=>"manual",
            "correo_personal"=>"graduate@gmail.com",
        ]);

        $user_service->createUser([
            'nombres' =>"graduate",
            'apellidos' =>"graduate",
            'es_administrador'=>false,
            'cedula' =>"22222222",
            'telefono' =>"22222222",
            "correo"=>"graduate@gmail.com",
            "modo_registro"=>"manual",
            "correo_personal"=>"graduate@gmail.com",
            "periodo_egreso"=>"prueba",
            "fecha_egreso"=>null,
            "carrera_id"=>"1",
            "notificacion"=>"1",
        ]);
        
        User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            "cedula"=> "11111111",
            'password' => Hash::make('123456'),
        ])->assignRole("administrator");

        User::firstOrCreate(['email' => 'graduate@gmail.com'], [
            'name' => 'graduate',
            'email' => 'graduate@gmail.com',
            'password' => Hash::make('123456'),
            "cedula"=> "22222222",
        ])->assignRole("graduate");

    }
}
