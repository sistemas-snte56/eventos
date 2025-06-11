<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    protected $fillable = [
        'delegacion_id', 'rfc', 'nombre', 'apaterno', 'amaterno',
        'genero', 'email', 'npersonal', 'telefono', 'ct',
        'cargo', 'nivel', 'curp', 'folio', 'slug',
        'codigo_id', 'codigo_qr', 'talon', 'ine_frontal', 'ine_reverso','localidad_id',
        'calle','colonia','cp',
    ];

    public function delegacion()
    {
        return $this->belongsTo(Delegacion::class);
    }

    public function temas()
    {
        return $this->belongsToMany(Tema::class)->withTimestamps();
    }
        
    // Relación: un participante pertenece a una localidad
    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }    
}
