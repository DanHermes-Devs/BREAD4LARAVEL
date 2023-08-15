<?php

namespace Danhermes\BreadForLaravel\Traits;

use Danhermes\BreadForLaravel\Models\Role;

trait HasRolesAndPermissions
{
    // Relación muchos a muchos con el modelo Role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    // Metodo para identificar si un usuario tiene un permiso específico
    public function havePermission($permission)
    {
        // return $this->roles;
        foreach ($this->roles as $role) {
            if ($role['full_access'] == 'yes') {
                return true;
            }
            foreach ($role->permissions as $perm) {
                if ($perm->action == $permission) {
                    return true;
                }
            }
        }

        return false;
    }

    // Método adicional para verificar si un usuario tiene un rol específico
    public function hasRole($roleName)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }
        return false;
    }

    // Condición para verificar si un usuario tiene un permiso específico
    // if ($user->hasPermission('browse')) {
    //     // Hacer algo
    // }

    // En el modelo user se debe configurar asi: 
    /**
     * use DanHermes\BreadForLaravel\Traits\HasRolesAndPermissions;
     * class User extends Authenticatable
     * {
     * use HasRolesAndPermissions;
     * 
     * // Resto del modelo...
     * }
     */
}