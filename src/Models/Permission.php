<?php

namespace DanHermes\BreadForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['bread_id', 'action', 'display_name'];

    public function roles()
    {
        // Si Role es parte de tu paquete, ajusta el namespace aquí
        return $this->belongsToMany(Role::class); 
        // Si Role es parte de tu paquete, cambia `Role::class` a `DanHermes\BreadForLaravel\Models\Role::class`
    }
}
