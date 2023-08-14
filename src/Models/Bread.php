<?php

namespace DanHermes\BreadForLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bread extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->hasMany(DanHermes\BreadForLaravel\Models\Permission::class);
    }
}
