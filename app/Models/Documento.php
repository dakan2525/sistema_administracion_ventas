<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;

class Documento extends Model
{
    use HasFactory;

    public function personas()
    {
        return $this->hasMany(Persona::class);
    }
}
