<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Models\{
    Colonia, Tema, Region, Delegacion, Municipio, Participante
};
use Illuminate\Support\Facades\Log;

class CastillaMujeres extends Component
{
    // Datos Laborales
    public $regions;
    public $selectedRegion;
    public $delegacions = [];
    public $selectedDelegacion;
    public $npersonal;
    public $nivel;

    // Datos Personales
    public $nombre;
    public $apaterno;
    public $amaterno;
    public $slug;
    public $rfc;
    public $genero;
    public $email;
    public $telefono;
    public $ct;
    public $cargo;
    public $curp;

    // Domicilio
    public $codigo_postal;
    
    /** @var \Illuminate\Support\Collection */
    public $colonias;

    public $colonia_id;
    
    /** @var \Illuminate\Support\Collection */
    public $municipios;

    public $municipio_nombre = null;
    public $municipio_id;
    public $calle;

    // Tema
    public $temas;
    public $tema_id;
    public $selectedTema;

    // Estado del formulario
    public $message = '';
    public $opcion = '';
    public $agremiado = false;

    public function mount()
    {
        $this->regions = Region::all();
        $this->municipios = collect();
        $this->colonias = collect();
    }

    
        public function rules()
        {
            $rules = [
                'opcion' => ['required', 'in:si,no'],
                'nombre' => ['required', 'min:3'],
                'apaterno' => ['required', 'min:3'],
                'amaterno' => ['nullable', 'min:3'],
                'rfc' => ['required', 'string', 'max:13', 'unique:participantes,rfc', 'regex:/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/i'],
                'email' => ['required', 'email', 'unique:participantes,email'],
                'telefono' => ['required', 'numeric', 'digits:10'],
                'codigo_postal' => ['required', 'numeric'],
                'colonia_id' => ['required'],
                'calle' => ['required', 'string', 'max:255'],
            ];

            if ($this->opcion == 'si') {
                $rules = array_merge($rules, [
                    'selectedRegion' => ['required'],
                    'selectedDelegacion' => ['required'],
                    'npersonal' => ['required', 'numeric', 'unique:participantes,npersonal'],
                    'nivel' => ['required'],
                ]);
            }

            return $rules;
        }

        public function messages()
        {
            return [
                'selectedRegion.required' => 'Debe seleccionar una región.',
                'selectedDelegacion.required' => 'Debe seleccionar una delegación.',
                'npersonal.required' => 'El número de personal es obligatorio.',
                'npersonal.numeric' => 'El número de personal debe ser numérico.',
                'npersonal.unique' => 'El número de personal ya está registrado.',
                'nivel.required' => 'Debe seleccionar un nivel educativo.',
                'nombre.required' => 'El campo nombre es obligatorio.',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
                'apaterno.required' => 'El campo apellido paterno es obligatorio.',
                'apaterno.min' => 'El apellido paterno debe tener al menos 3 caracteres.',
                'amaterno.min' => 'El apellido materno debe tener al menos 3 caracteres.',
                'rfc.regex' => 'El RFC debe tener un formato válido, por ejemplo: ABCD850101ABC',
                'rfc.unique' => 'Este RFC ya está registrado.',
                'rfc.required' => 'El campo RFC es obligatorio.',
                'rfc.max' => 'El RFC no puede tener más de 13 caracteres.',
                'email.required' => 'El campo correo es obligatorio.',
                'email.email' => 'El correo electrónico no es válido.',
                'email.unique' => 'Este correo ya está registrado.',
                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.numeric' => 'El teléfono debe ser un número.',
                'telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos.',
                'calle.max' => 'La calle no puede tener más de 255 caracteres.',
                'colonia_id.required' => 'Debe seleccionar una localidad.',
                'calle.required' => 'El campo calle es obligatorio.',
                'codigo_postal.required' => 'El campo código postal es obligatorio.',
                'codigo_postal.numeric' => 'El campo código postal debe ser numérico.',
            ];
        }        
   
    public function updatedSelectedRegion()
    {
        $this->delegacions = Delegacion::where('region_id', $this->selectedRegion)
            ->orderBy('deleg_delegacional', 'asc')
            ->get();

        $this->selectedDelegacion = null;
    }

    public function updatedCodigoPostal($value)
    {
        $this->colonias = Colonia::where('codigo_postal', $value)
            ->orderBy('nombre', 'asc')
            ->get();

        $this->municipios = Municipio::whereIn('id', $this->colonias->pluck('municipio_id'))
            ->get();

        if ($this->colonias->count() === 1) {
            $this->colonia_id = $this->colonias->first()->id;
        }

        if ($this->municipios->count() === 1) {
            $municipio = $this->municipios->first();
            $this->municipio_id = $municipio->id;
            $this->municipio_nombre = $municipio->nombre;
        } else {
            $this->municipio_id = null;
            $this->municipio_nombre = null;
        }
    }

    public function guardar()
    {


        $this->tema_id = 7;
        $this->selectedTema = Tema::find($this->tema_id);

        $this->validate();


        // Log::info('Registro de participante iniciado', [
        //     'opcion' => $this->opcion,
        //     'selectedRegion' => $this->selectedRegion,
        //     'selectedDelegacion' => $this->selectedDelegacion,
        //     'nombre' => $this->nombre,
        //     'apaterno' => $this->apaterno,
        //     'amaterno' => $this->amaterno,
        //     'rfc' => $this->rfc,
        //     'email' => $this->email,
        //     'telefono' => $this->telefono,
        //     'codigo_postal' => $this->codigo_postal,
        //     'colonia_id' => $this->colonia_id,
        //     'calle' => $this->calle,
        // ]);

        $this->slug = Str::slug("{$this->nombre}-{$this->apaterno}-{$this->amaterno}");

        do {
            $folio = 'SNT56-' . date('Y') . '-' . strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(8));
        } while (Participante::where('folio', $folio)->exists());

        if ($this->opcion === 'no') {
            $this->selectedRegion = 13;
            $this->selectedDelegacion = 338;
            $this->npersonal = 0;
            $this->nivel = 'Preescolar';
        }

        // dd($this);

        $participante = Participante::create([
            'delegacion_id' => $this->selectedDelegacion,
            'rfc' => strtoupper($this->rfc),
            'nombre' => strtoupper($this->nombre),
            'apaterno' => strtoupper($this->apaterno),
            'amaterno' => strtoupper($this->amaterno),
            'genero' => 'Mujer',
            'email' => $this->email,
            'npersonal' => $this->npersonal,
            'telefono' => $this->telefono,
            'ct' => $this->ct,
            'cargo' => $this->cargo,
            'nivel' => $this->nivel,
            'curp' => $this->curp,
            'folio' => $folio,
            'slug' => $this->slug,
            'codigo_id' => sprintf(
                "%04s-%04s-%04s-%04s",
                substr(uniqid(), 0, 4),
                substr(uniqid(), 4, 4),
                substr(uniqid(), 8, 4),
                substr(uniqid(), 12, 4)
            ),
            'codigo_postal' => strtoupper($this->codigo_postal),
            'colonia_id' => $this->colonia_id,
            'calle' => strtoupper($this->calle),
        ]);

        $participante->temas()->attach($this->selectedTema);

        $this->resetInput();

        $this->dispatch("sweet.success", message: 'Participante creado exitosamente con folio:<br><h3>' . $folio . '</h3>');
    }

    public function resetInput()
    {
        $this->reset([
            'selectedTema', 'selectedRegion', 'selectedDelegacion', 'nombre',
            'apaterno', 'amaterno',  'email', 'npersonal', 'telefono',
            'nivel', 'rfc', 'tema_id', 'slug', 'municipio_id',

            'colonia_id', 'calle', 'colonias', 'codigo_postal', 'opcion'
        ]);
        $this->colonias = collect();
        $this->municipios = collect();
    }



    public function render()
    {
        return view('livewire.castilla-mujeres');
    }
}