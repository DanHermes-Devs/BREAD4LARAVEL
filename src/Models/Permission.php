<?php

namespace Danhermes\BreadForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Danhermes\BreadForLaravel\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['bread_id', 'action', 'display_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class); 
    }
}
