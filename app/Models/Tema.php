<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion'];

    public function participantes()
    {
        return $this->belongsToMany(Participante::class)->withTimestamps();
    }
    
    protected $temas = [
        'temas' => 'array',
    ];        
}
