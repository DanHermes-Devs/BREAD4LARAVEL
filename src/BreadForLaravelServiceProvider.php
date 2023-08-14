<?php

namespace DanHermes\BreadForLaravel;

use Illuminate\Support\ServiceProvider;

class BreadForLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeBread::class,
            ]);

            // // Publica las migraciones
            // $this->publishes([
            //     __DIR__.'/src/Migrations' => database_path('migrations')
            // ], 'migrations');

            // // Publica las vistas
            // $this->publishes([
            //     __DIR__.'/../resources/views' => resource_path('views/vendor/bread-for-laravel'),
            // ], 'views');

            // // Publica los modelos
            // $this->publishes([
            //     __DIR__.'/src/Models' => app_path('Models'),
            // ], 'models');

            // // Publica los controladores
            // $this->publishes([
            //     __DIR__.'/src/Controllers' => app_path('Http/Controllers'),
            // ], 'controllers');

            // // Publica los comandos
            // $this->publishes([
            //     __DIR__.'/src/Commands' => app_path('Console/Commands'),
            // ], 'commands');

            // Definimos los diferentes grupos de publicables
            $migrations = [__DIR__.'/src/Migrations' => database_path('migrations')];
            $views = [__DIR__.'/../resources/views' => resource_path('views/vendor/bread-for-laravel')];
            $models = [__DIR__.'/src/Models' => app_path('Models')];
            $controllers = [__DIR__.'/src/Controllers' => app_path('Http/Controllers')];
            $commands = [__DIR__.'/src/Commands' => app_path('Console/Commands')];

            // Publica por separado
            $this->publishes($migrations, 'migrations');
            $this->publishes($views, 'views');
            $this->publishes($models, 'models');
            $this->publishes($controllers, 'controllers');
            $this->publishes($commands, 'commands');

            // Publica todo junto
            $this->publishes(array_merge(
                $migrations, $views, $models, $controllers, $commands
            ), 'all');

            // Comando a usar para publicar todo junto
            // php artisan vendor:publish --tag=all

            // Comando a usar para publicar por separado
            // php artisan vendor:publish --tag=migrations
            // php artisan vendor:publish --tag=views
            // php artisan vendor:publish --tag=models
            // php artisan vendor:publish --tag=controllers
            // php artisan vendor:publish --tag=commands

            // Carga las rutas
            $this->loadRoutesFrom(__DIR__.'/Routes/routes.php');
        }

    }

    public function register()
    {
        // Aquí puedes hacer bindings al container si es necesario.
    }
}
