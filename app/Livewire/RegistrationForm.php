<?php

namespace App\Livewire;

use App\Models\Tema;
use App\Models\Region;
use Livewire\Component;
use App\Models\Delegacion;
use Illuminate\Support\Str;
use App\Models\Participante;
use Livewire\Attributes\Validate;




class RegistrationForm extends Component
{

    public $regions;
    public $delegacions = [];
    public $temas;
    public $tema_id;

    public $selectedRegion;
    public $selectedTema;

    public $amaterno;
    public $message = '';

    public $selectedDelegacion;
    public $nombre;
    public $apaterno;
    public $genero;
    public $email;
    public $npersonal;
    public $telefono;
    public $nivel;    
    public $slug;    
    public $rfc;    

    /*
        #[Validate('required', message: 'Debe seleccionar al menos una opción.')]
        public $selectedDelegacion;   
        
        #[Validate('required', message: 'El campo nombre es obligatorio.')]
        #[Validate('min:3', message: 'El nombre debe tener al menos 3 caracteres.')]
        public $nombre;
        
        #[Validate('required', message: 'El campo apellido paterno es obligatorio.')]
        #[Validate('min:3', message: 'El apellido paterno debe tener al menos 3 caracteres.')]
        public $apaterno;
        
        #[Validate('required', message: 'Debe seleccionar al menos una opción.')]
        public $genero;

        #[Validate('required', message: 'El campo correo es obligatorio.')]
        #[Validate('email', message: 'El correo electrónico no es válido.')]
        #[Validate('unique:participantes,email', message: 'Este correo ya está registrado.')]
        public $email;

        
        #[Validate('required', message: 'El campo número de personal es obligatorio.')]
        #[Validate('numeric', message: 'El campo solo acepta números.')]
        #[Validate('unique:participantes,npersonal', message: 'El número de personal ya está registrado.')]
        public $npersonal;

        #[Validate('required', message: 'El teléfono es obligatorio.')]
        #[Validate('numeric', message: 'El teléfono debe ser un número.')]
        #[Validate('digits:10', message: 'El teléfono debe tener exactamente 10 dígitos.')]
        public $telefono;

        
        #[Validate('required', message: 'Debe seleccionar al menos una opción.')]
        public $nivel;
        #[Validate('required', message: 'El campo nombre es obligatorio.')]    
    
    */


    public function rules()
    {
        return [
            'selectedDelegacion' => ['required'],
            'nombre' => ['required', 'min:3'],
            'apaterno' => ['required', 'min:3'],
            'rfc' => [
                'required',
                'string',
                'max:13',
                'unique:participantes,rfc',
                'regex:/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/i' // 👈 modificador i
            ],
            'genero' => ['required'],
            'email' => ['required', 'email', 'unique:participantes,email'],
            'npersonal' => ['required', 'numeric', 'unique:participantes,npersonal'],
            'telefono' => ['required', 'numeric', 'digits:10'],
            'nivel' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'selectedDelegacion.required' => 'Debe seleccionar al menos una opción.',

            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',

            'apaterno.required' => 'El campo apellido paterno es obligatorio.',
            'apaterno.min' => 'El apellido paterno debe tener al menos 3 caracteres.',

            'rfc.regex' => 'El RFC debe tener un formato válido, por ejemplo: ABCD850101ABC',
            'rfc.unique' => 'Este RFC ya está registrado.',
            'rfc.required' => 'El campo RFC es obligatorio.',
            'rfc.max' => 'El RFC no puede tener más de 13 caracteres.',

            'genero.required' => 'Debe seleccionar al menos una opción.',

            'email.required' => 'El campo correo es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'npersonal.required' => 'El campo número de personal es obligatorio.',
            'npersonal.numeric' => 'El campo solo acepta números.',
            'npersonal.unique' => 'El número de personal ya está registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.numeric' => 'El teléfono debe ser un número.',
            'telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos.',

            'nivel.required' => 'Debe seleccionar al menos una opción.',
        ];
    }


    public function mount()
    {
        $this->regions = Region::all();
        $this->temas = Tema::all();
    }

    public function updatedSelectedRegion()
    {
        $regionId = $this->selectedRegion;

        $this->delegacions = Delegacion::where('region_id', $regionId)
                                ->orderBy('deleg_delegacional', 'asc')
                                ->get();
        $this->selectedDelegacion = null;

        // Esto te ayuda a confirmar que entra aquí
        $this->message = 'Región actualizada: ' . $regionId;
    }

    public function render()
    {
        return view('livewire.registration-form');
    }

    public function guardar()
    {
        // Validación
        $this->validate();

        // Generamos el slug
        $this->slug = Str::slug($this->nombre.'-'.$this->apaterno.'-'.$this->amaterno);

        // Generar folio único
        do {
            $folio = 'SNT56-' . date('Y') . '-' . Str::upper(Str::random(3)) . '-' . Str::upper(Str::random(8));
        } while (Participante::where('folio', $folio)->exists());

        // Crear participante
        $participante = Participante::create([
            'delegacion_id' => $this->selectedDelegacion,
            'rfc' => mb_strtoupper($this->rfc, 'UTF-8'),
            'nombre' => mb_strtoupper($this->nombre, 'UTF-8'),
            'apaterno' => mb_strtoupper($this->apaterno, 'UTF-8'),
            'amaterno' => mb_strtoupper($this->amaterno, 'UTF-8'),
            'genero' => $this->genero,
            'email' => $this->email,
            'npersonal' => $this->npersonal,
            'telefono' => $this->telefono,
            'cargo' => 'empty',
            'nivel' => $this->nivel,
            'folio' => $folio,
            'slug' => $this->slug,
            'codigo_id' => sprintf(
                "%04s-%04s-%04s-%04s",
                substr(uniqid(), 0, 4),
                substr(uniqid(), 4, 4),
                substr(uniqid(), 8, 4),
                substr(uniqid(), 12, 4)
            ),
        ]);

        // Asociar el participante con el curso en la tabla intermedia
        $participante->temas()->attach($this->selectedTema);

        // Redirección o limpieza de campos
        $this->resetInput();

        // Mensaje de confirmación
        $this->dispatch("sweet.success", message: 'Participante creado exitosamente con folio:<br><h3>'.$folio.'</h3>');
    }

    public function resetInput()
    {
        $this->reset([
            'selectedTema',
            'selectedRegion',
            'selectedDelegacion',
            'nombre',
            'apaterno',
            'amaterno',
            'genero',
            'email',
            'npersonal',
            'telefono',
            'nivel',
            'rfc',
            'tema_id'
        ]);
    }



}
