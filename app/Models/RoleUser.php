<?php

declare (strict_types = 1);
namespace App\Models;
use App\Models\User;
use App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    public $table = "role_user";
    protected $fillable = [
        'role_id', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}