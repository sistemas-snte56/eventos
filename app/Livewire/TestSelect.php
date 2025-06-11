<?php

namespace App\Livewire;

use Livewire\Component;

class TestSelect extends Component
{
    public $selectedOption;
    public $options = [1 => 'Uno', 2 => 'Dos', 3 => 'Tres'];

    public function updatedSelectedOption($value)
    {
        log('Seleccionado: ' . $value); // ← DEBE aparecer en logs
        dump('Livewire funcionando. Valor seleccionado: ' . $value); // ← DEBE verse en la página
    }

    public function render()
    {
        return view('livewire.test-select');
    }
}
