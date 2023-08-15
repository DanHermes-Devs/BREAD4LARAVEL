<?php

namespace Danhermes\BreadForLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Danhermes\BreadForLaravel\Models\Bread;
use Danhermes\BreadForLaravel\Models\Permission;
use Illuminate\Support\Str;

class MakeBread extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:bread {model} {--api : Indicate if the controller should be an API controller} {--r : Indicate if the controller should be a resource controller with model and migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('model');

        // Paso 1: Crear el modelo.
        if (!class_exists("App\\Models\\{$modelName}")) {
            Artisan::call('make:model', ['name' => $modelName]);
        } else {
            $this->warn("El modelo {$modelName} ya existe.");
        }

        // Paso 2: Crear el controlador.
        $controllerName = $this->getControllerName($modelName);
        if (!class_exists("App\\Http\\Controllers\\{$controllerName}")) {
            $this->createController($modelName);
        } else {
            $this->warn("El controlador {$controllerName} ya existe.");
        }

        // Paso 3: Crear la migración.
        $migrationName = "create_" . strtolower(Str::plural($modelName)) . "_table";
        if (!$this->migrationExists($migrationName)) {
            Artisan::call('make:migration', ['name' => $migrationName]);
        } else {
            $this->warn("La migración {$migrationName} ya existe.");
        }

        // Paso 4: Insertar un nuevo BREAD.
        $bread = Bread::firstOrCreate(['name' => $modelName]);

        $actions = ['buscar', 'ver', 'editar', 'crear', 'borrar'];

        // Paso 5: Crea los permisos asociados si no existen.
        foreach ($actions as $action) {
            $permissionName = $action . '_' . strtolower($modelName);
            if (!Permission::where('action', $permissionName)->where('bread_id', $bread->id)->exists()) {
                Permission::create([
                    'bread_id' => $bread->id,
                    'action' => $permissionName,
                    'display_name' => ucfirst($action) . ' ' . ucfirst($modelName)
                ]);
            }
        }

        // Paso 6: Crear las vistas.
        $this->createViews($modelName);

        $this->info('Operaciones realizadas exitosamente.');
    }

    /**
     * Create the basic views for the model.
     *
     * @param  string  $modelName
     * @return void
     */
    protected function createViews($modelName)
    {
        $views = ['index', 'create', 'edit', 'show'];
        $viewPath = resource_path("views/{$modelName}");

        if (!is_dir($viewPath)) {
            mkdir($viewPath, 0755, true);
        }

        foreach ($views as $view) {
            $viewFullPath = "{$viewPath}/{$view}.blade.php";
            if (!file_exists($viewFullPath)) {
                if ($view === 'index') {
                    $content = <<<EOD
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row g-5 g-xl-8">
        <div class="col-12">
            <div class="card crm-widget py-4 px-3">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>¡Éxito!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
    
                    <div class="d-flex gap-3 justify-content-end mb-4">
                        <div class="d-flex justify-content-end">
                            <a href="#" class="btn btn-primary d-flex align-items-center justify-content-center gap-1 fs-5">
                                <i class="fas fa-chart-pie"></i>
                                Crear
                            </a>
                        </div>
                    </div>
    
                    <table class="table table-striped" id="table_roles">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>
                                    <button>Ver</button>
                                    <button>Editar</button>
                                    <button>Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#table_roles').DataTable();
    });
</script>
@endsection
EOD;
                } else {
                    $content = "@extends('layouts.app')\n\n@section('content')\n    <!-- TODO: {$view} content for {$modelName} -->\n@endsection";
                }

                file_put_contents($viewFullPath, $content);
                $this->info("View {$view}.blade.php for {$modelName} created.");
            } else {
                $this->warn("View {$view}.blade.php for {$modelName} already exists.");
            }
        }
    }


    /**
     * Check if the migration already exists.
     *
     * @param  string  $migrationName
     * @return bool
     */
    protected function migrationExists($migrationName)
    {
        $migrations = glob(database_path("/migrations/*.php"));
        foreach ($migrations as $migration) {
            if (str_contains($migration, $migrationName)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Create the controller based on the type specified.
     *
     * @param  string  $modelName
     * @return void
     */
    protected function createController($modelName)
    {
        $isApiController = $this->option('api');
        $isMcrController = $this->option('r');

        if ($isApiController) {
            $path = "API/{$modelName}/{$modelName}Controller";
            Artisan::call("make:controller", ['name' => $path, '--api' => true]);
        } elseif ($isMcrController) {
            Artisan::call("make:controller", ['name' => "{$modelName}Controller", '--resource' => true, '--model' => "App\\Models\\{$modelName}"]);
        } else {
            Artisan::call("make:controller", ['name' => "{$modelName}Controller"]);
        }
    }

    /**
     * Get the name of the controller based on options.
     *
     * @param  string  $modelName
     * @return string
     */
    protected function getControllerName($modelName)
    {
        if ($this->option('api')) {
            return "API\\{$modelName}\\{$modelName}Controller";
        } else {
            return "{$modelName}Controller";
        }
    }
}
