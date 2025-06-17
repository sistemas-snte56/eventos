<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;
    
    protected $table = 'municipios'; // nombre de la tabla
    protected $fillable = ['id', 'nombre'];
    public $incrementing = false; // porque usas IDs manuales

    // Relación: un Municipio tiene muchas Localidades
    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }

    // Relación: un Municipio tiene muchas Colonias
    public function colonias()
    {
        return $this->hasMany(Colonia::class);
    }    
}
