<?php

namespace Danhermes\BreadForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Danhermes\BreadForLaravel\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'full_access'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }
}