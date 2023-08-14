<?php

use App\Http\Controllers\RoleControler;

Route::get('/roles', [RoleControler::class, 'create'])->name('roles.create');

