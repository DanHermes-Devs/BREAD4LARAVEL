<?php

namespace Danhermes\BreadForLaravel;

use Illuminate\Support\ServiceProvider;
use Danhermes\BreadForLaravel\Commands\MakeBread;

class BreadForLaravelServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Aquí puedes hacer bindings al container si es necesario.
    }

    public function boot()
    {
        // Comandos de artisan
        $this->commands([
            MakeBread::class
        ]);

        // Cargamos las migraciones
        $this->loadMigrationsFrom([
            __DIR__ . '/../database/migrations'
        ]);

        // Carga de rutas
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Carga de vistas
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'BreadPermissions');

        // Publicación de archivos
        $migrations = [__DIR__ . '/../database/migrations' => database_path('migrations')];
        $seeds = [__DIR__ . '/../database/seeders' => database_path('seeders')]; // Llamamos al seeder de roles y permisos $this->call(RolePermissionSeeder::class); en el DatabaseSeeder.php
        $views = [__DIR__ . '/../resources/views' => resource_path('views/vendor/BreadPermissions')];

        // Publica por separado
        $this->publishes($migrations, 'migrations');
        $this->publishes($views, 'views');
        $this->publishes($seeds, 'seeds');

        // Publicamos todo junto
        $this->publishes(array_merge(
            $migrations, $views, $seeds
        ), 'all');
    }
}
