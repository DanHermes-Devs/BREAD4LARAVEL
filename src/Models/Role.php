<?php

namespace DanHermes\BreadForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id'); 
        // Nota: Si tienes una tabla intermedia personalizada (por ejemplo, "permission_role"), 
        // y usas columnas personalizadas para las claves foráneas, asegúrate de incluirlas 
        // como se muestra arriba. Si no es así, puedes omitir esos argumentos.
    }
}
