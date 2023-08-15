<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Danhermes\BreadForLaravel\Models\Bread;
use Danhermes\BreadForLaravel\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Bread::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Creamos el BREAD de usuarios
        Bread::create([
            'name' => 'Usuarios',
        ]);

        // Creamos el BREAD de roles
        Bread::create([
            'name' => 'Roles',
        ]);

        // Creamos los permisos para el BREAD de roles
        $bread = Bread::where('name', 'roles')->first();

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'buscar_roles',
            'display_name' => 'Buscar roles',
        ]);

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'ver_roles',
            'display_name' => 'Ver roles',
        ]);

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'editar_roles',
            'display_name' => 'Editar roles',
        ]);

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'crear_roles',
            'display_name' => 'Agregar roles',
        ]);

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'borrar_roles',
            'display_name' => 'Eliminar roles',
        ]);

    }
}
