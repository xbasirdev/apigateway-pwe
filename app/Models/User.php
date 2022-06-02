<?php

declare (strict_types = 1);
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Return all user roles.
     *
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Return all user permissions.
     *
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    
    //Determinar si el usuario tiene un role especifico
    public function hasRole($role)
    {
        $where = null;
        if (is_numeric($role)) {
            $where = ['id', $role];
        } elseif (is_string($role)) {
            $where = ['slug', $role];
        } elseif ($role instanceof Role) {
            $where = ['slug', $role->slug];
        }

        if ($role != null && $where != null) {
            return null !== $this->roles->where(...$where)->first();
        }

        return false;
    }

    //Determinar si el usuario tiene un permiso especifico
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
            return (bool) ($this->permissions->where(...$where)->count())
            || $this->hasPermissionThroughRole($permission);
        }

        return false;
    }

    //determina si un usuario pertenece a un grupo con un permiso especifico
    public function hasPermissionThroughRole($permission)
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
            foreach ($this->roles as $role) {
                if ($role->permissions->where(...$where)->count() > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    //Asignar todos los permisos a un usuario
    public function assignAllPermissions()
    {
        Permission::all()->map(function ($permission) {
            return $this->assignPermissions([$permission]);
        });
        return $this;
    }

    //asignar todos los roles a un usuario
    public function assignAllRoles()
    {
        Role::all()->map(function ($role) {
            return $this->assignrole([$role]);
        });

        return $this;
    }

    //eliminar todos los permisos a un usuario
    public function revokeAllPermissions()
    {
        $this->permissions()->detach();
        return $this;
    }

    //eliminar todos los roles a un usuario
    public function revokeAllRoles()
    {
        $this->roles()->detach();

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

    //Eliminar rol especifico a usuario
    public function revokeRole(...$roles)
    {
        $roles = $this->getCorrectParameter($roles);
        $roles = $this->getRoleIds($roles);
        if ($roles->count() == 0) {
            return false;
        }
        $this->roles()->detach($roles);

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

    //asignar rol especifico al usuario
    public function assignRole(...$roles)
    {
        $roles = $this->getCorrectParameter($roles);
        $roles = $this->convertToRoleIds($roles);
        if ($roles->count() == 0) {
            return false;
        }
        $this->roles()->syncWithoutDetaching($roles);
        return $this;
    }

    //asignar permiso especifico al usuario
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

    //Comprueba si un usuario tiene algún permiso.
    public function hasAnyPermission(...$permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    //Comprueba si un usuario tiene algún Rol.
    public function hasAnyRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    //Comprueba si un usuario tiene todos los roles.
    public function hasAllroles(...$roles)
    {
        foreach ($roles as $role) {
            if (!$this->hasrole($role)) {
                return false;
            }
        }
        return true;
    }

    //Comprueba si un usuario tiene todos los permisos
    public function hasAllPermissions(...$permissions)
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    //Determina el tipo de parametro usado
    private function getCorrectParameter(array $param)
    {
        if (is_array($param[0])) {
            return $param[0];
        }

        return $param;
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

    private function convertToRoleIds($role)
    {
        $role = ! is_array($role) ? [$role] : $role;
        return collect(array_filter(array_map(function ($role) {
            if ($role instanceof Role) {
                return $role->id;
            } elseif (is_numeric($role)) {
                $_group = Role::find($role);
                if ($_group instanceof Role) {
                    return $_group->id;
                } 
            } elseif (is_string($role)) {
                $_group = Role::where('slug', $role)->first();
                if ($_group instanceof Role) {
                    return $_group->id;
                } 
            }
        }, $role)));
    }
}
