<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'slug', 'id', 'description', 'name',
    ];

    public function getTranslatedNameAttribute()
    {
        return __($this->slug);
    }
    public function roles()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

   
}
