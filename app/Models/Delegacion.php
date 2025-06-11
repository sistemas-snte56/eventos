<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegacion extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'deleg_delegacional', 'nivel_delegacional', 'sede_delegacional'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function participantes()
    {
        return $this->hasMany(Participante::class);
    }    
}
