<?php

use DanHermes\BreadForLaravel\Http\Controllers\RoleController;

Route::get('/roles', [RoleController::class, 'create'])->name('roles.create');

