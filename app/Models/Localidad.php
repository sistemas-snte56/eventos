<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $table = 'localidades'; // nombre de la tabla
    protected $fillable = ['id', 'nombre', 'municipio_id'];
    public $incrementing = false;

    // Relación: una Localidad pertenece a un Municipio
    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }    
}
