<?php

declare (strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;

class Role extends Model
{
    protected $fillable = [
        'slug', 'id', 'description', 'name',
    ];

    public function getTranslatedNameAttribute()
    {
        return __($this->name);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_user');
    }

    //verificar si el role tiene permiso
    public function hasPermission($permission)
    {
        $where = null;
        if (is_numeric($permission)) {
            $where = ['id', $permission];
        } elseif (is_string($permission)) {
            $where = ['slug', $permission];
        } elseif ($permission instanceof Permission) {
            $where = ['slug', $permission->slug];
        }
        if ($permission != null && $where != null) {
            return null !== $this->permissions->where(...$where)->first();
        }

        return false;
    }

    //asignar permisos especificos al rol
    public function assignPermissions(...$permissions)
    {
        $permissions = $this->getCorrectParameter($permissions);
        $permissions = $this->convertToPermissionIds($permissions);
        if ($permissions->count() == 0) {
            return false;
        }
        $this->permissions()->syncWithoutDetaching($permissions);

        return $this;
    }

    //asignar todos los permisos
    public function assignAllPermissions()
    {
        $permissionModel = Permission::all()->map(function ($permission) {
            return $this->assignPermissions([$permission]);
        });
        return $this;
    }

    //eliminar todos los permisos del role
    public function revokeAllPermissions()
    {
        $this->permissions()->detach();
        return $this;
    }

    //eliminar permisos especificos a un usuario
    public function revokePermissions(...$permissions)
    {
        $permissions = $this->getCorrectParameter($permissions);
        $permissions = $this->getPermissionIds($permissions);
        $this->permissions()->detach($permissions);

        return $this;
    }

    //obtener id del permiso
    protected function getPermissionIds(array $permissions)
    {
       return collect(array_map(function ($permission){
            if (is_numeric($permission)) {
                $_permission = Permission::find($permission);
            } elseif (is_string($permission)) {
                $_permission = Permission::where('slug', $permission)->first();
            } elseif ($permission instanceof Permission) {
                $_permission = $permission;
            }
            if (isset($_permission)) {
                if (! is_null($_permission)) {
                    return $_permission->id;
                }
            }
        }, $permissions));
    }

    //Comprueba si un rol tiene algún permiso.
    public function hasAnyPermission(...$permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    //Comprueba si un rol tiene todos los permisos
    public function hasAllPermissions(...$permissions)
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }   
        return true;
    }


    //obtener id del permiso
    private function convertToPermissionIds($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : [$permissions];

        $d= collect(array_filter(array_map(function ($permission){
            if ($permission instanceof Permission) {
                return $permission->id;
            } elseif (is_numeric($permission)) {
                $_permission = Permission::find($permission);
                if ($_permission instanceof Permission) {
                    return $_permission->id;
                }
            } elseif (is_string($permission)) {
                
                $_permission = Permission::where('slug', $permission)->first();
                if ($_permission instanceof Permission) {
                    return $_permission->id;
                } 
            }
        }, $permissions)));
        return $d;
    }


    private function getCorrectParameter($param)
    {
        if (is_array($param[0])) {
            return $param[0];
        }
        return $param;
    }
}
