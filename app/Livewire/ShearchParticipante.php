<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Participante;

class ShearchParticipante extends Component
{
    public $query = '';
    public $resultados = [];

    public function buscar()
    {
        $q = trim($this->query);

        if (strlen($q) >= 3) {
            $this->resultados = Participante::where(function ($query) use ($q) {
                $query->where('npersonal', 'like', "%$q%")
                      ->orWhere('folio', 'like', "%$q%")
                      ->orWhereRaw('RIGHT(folio, 4) = ?', [$q])
                      ->orWhere('email', 'like', "%$q%");
            })->get();
        } else {
            $this->resultados = [];
        }
    }    

    public function render()
    {
        return view('livewire.shearch-participante');
    }


}
