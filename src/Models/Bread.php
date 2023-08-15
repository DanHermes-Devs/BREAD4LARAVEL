<?php

namespace Danhermes\BreadForLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Danhermes\BreadForLaravel\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bread extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
