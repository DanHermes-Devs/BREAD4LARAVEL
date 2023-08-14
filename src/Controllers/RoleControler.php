<?php

namespace DanHermes\BreadForLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController; // Usamos la base de controlador de Laravel directamente.
use DanHermes\BreadForLaravel\Models\Bread;

class RoleController extends BaseController
{
    public function create()
    {
        $breads = Bread::with('permissions')->get();
        
        // Asumimos que tendrás una vista 'roles' dentro de una carpeta 'bread-for-laravel' en tus vistas.
        return view('bread-for-laravel::roles', ['breads' => $breads]);
    }
}
