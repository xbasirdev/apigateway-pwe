<?php

declare (strict_types = 1);
use Illuminate\Database\Seeder;
use \App\Models\Role;
use \App\Models\Permission;

use Illuminate\Support\Facades\Log;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //rutas que no se evaluan en los permisos
        $except = ["auth.login", "auth.refresh", "auth.logout"];

        //rutas de los egresados
        $permission_graduate = [
            "route:acto-grado.index",
            "route:acto-grado.show",
            "route:evento.index",
            "route:evento.show",
            "route:presentacion-dep.index",
            "route:presentacion-dep.show",
            "route:actividad-extension.index",
            "route:actividad-extension.show",
            "route:bolsa-egresado.index",
            "route:bolsa-trabajo.index",
            "route:bolsa-trabajo.show",
            "route:bolsa-trabajo.store",
            "route:bolsa-egresado.show",
            "route:bolsa-egresado.store",
            "route:bolsa-egresado.update",
            "route:bolsa-egresado.destroy",
            "route:egresado.show",
            "route:egresado.store",
            "route:egresado.update",
            "route:cuestionario.index",
            "route:cuestionario.store",
            "route:cuestionario.store",
            "route:carrera.index",
            "route:carrera.show",
            "route:objetivoCuestionario.show",
            "route:user.show",
            "route:egresado.change-notification-status"
        ];

        //crear permisos segun las rutas encontradas
        $routeName = json_encode(Route::getRoutes());
        foreach (Route::getRoutes() as $key => $value) {
            if (array_key_exists("as", $value["action"])) {
                $route=$value["action"]["as"];
                if(!in_array($route, $except)){
                    Permission::firstOrCreate(['slug' => "route:{$route}"], ['name' => "route:{$route}"]);
                }                
            }
        }

        //asignacion de todas las rutas a los administradores
        Role::firstOrCreate(['slug' => 'administrator'])->assignAllPermissions();
       
        //asignacion de rutas a rol egresados
        Role::firstOrCreate(['slug' => 'graduate'])->assignPermissions($permission_graduate);

    }
}
