<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Danhermes\BreadForLaravel\Models\Role;
use Danhermes\BreadForLaravel\Models\Bread;
use Danhermes\BreadForLaravel\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('user_role')->truncate();
            DB::table('role_permission')->truncate();
            Role::truncate();
            Permission::truncate();
            Bread::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Usuario administador
        $useradmin = User::where('email', 'danhermes@outlook.com')->first();
        if($useradmin) {
            $useradmin->delete();
        }

        // Usuario administrador
        $useradmin = User::create([
            'name' => 'Dan',
            'email' => 'danhermes@outlook.com',
            'password' => bcrypt('12345678'),
        ]);

        // Usuario usuario
        $useruser = User::create([
            'name' => 'Genesis',
            'email' => 'hermes@outlook.com',
            'password' => bcrypt('12345678'),
        ]);

        // Rol administrador
        $roladmin = Role::create([
            'name' => 'admin',
        ]);

        // Rol usuario
        $roluser = Role::create([
            'name' => 'user',
        ]);

        // Table user_role
        $useradmin->roles()->sync([$roladmin->id]);
        $useruser->roles()->sync([$roluser->id]);

        // Permisos
        $permission_all = [];

        // BREAD
        $bread = Bread::create([
            'name' => 'users',
        ]);

        // Permisos de usuarios
        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'buscar_users',
            'display_name' => 'Buscar Users',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'ver_users',
            'display_name' => 'Leer Users',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'editar_users',
            'display_name' => 'Editar Users',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'crear_users',
            'display_name' => 'Crear Users',
        ]);

        $permission_all[] = $permission->id;

        $permission = Permission::create([
            'bread_id' => $bread->id,
            'action' => 'eliminar_users',
            'display_name' => 'Eliminar Users',
        ]);

        $permission_all[] = $permission->id;

        // Table role_permission
        $roladmin->permissions()->sync($permission_all);

    }
}
