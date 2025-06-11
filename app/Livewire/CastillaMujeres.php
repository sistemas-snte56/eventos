<?php

namespace App\Livewire;

use App\Models\Tema;
use App\Models\Region;
use Livewire\Component;
use App\Models\Municipio;
use App\Models\Delegacion;
use App\Models\Localidad;
use Illuminate\Support\Str;
use App\Models\Participante;

class CastillaMujeres extends Component
{

    #Datos Laborales
    public $regions;
    public $selectedRegion;
    public $delegacions = [];
    public $selectedDelegacion;
    public $npersonal;
    public $nivel;    

    #Datos Personales
    public $nombre;
    public $apaterno;
    public $amaterno;
    public $slug;    
    public $rfc;       
    public $genero;
    public $email;
    public $telefono;
    

    #Datos de Domicilio
    public $municipios;
    public $selectedMunicipio;
    public $localidades = [];
    public $localidad_id;
    public $calle;
    public $colonia;
    public $cp;
    


    #Tema
    public $temas;
    public $tema_id;
    public $selectedTema;

    public $message = '';
    public $opcion = '';
    public $agremiado = false;
    
    public function rules()
    {
        $rules = [
            'opcion' => ['required', 'in:si,no'],

            'nombre' => ['required', 'min:3'],
            'apaterno' => ['required', 'min:3'],
            'amaterno' => ['nullable', 'min:3'],
            'rfc' => [
                'required',
                'string',
                'max:13',
                'unique:participantes,rfc',
                'regex:/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/i'
            ],
            'genero' => ['required'],
            'email' => ['required', 'email', 'unique:participantes,email'],
            'telefono' => ['required', 'numeric', 'digits:10'],

            'localidad_id' => ['required'],
            'calle' => ['required', 'string', 'max:255'],
            'colonia' => ['required', 'string', 'max:255'],
            'cp' => ['required', 'numeric'],
        ];

        if ($this->opcion === 'si') {
            $rules['selectedRegion'] = ['required'];
            $rules['selectedDelegacion'] = ['required'];
            $rules['npersonal'] = ['required', 'numeric', 'unique:participantes,npersonal'];
            $rules['nivel'] = ['required'];
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
            'amaterno.nullable' => 'El apellido materno es opcional.',

            'rfc.regex' => 'El RFC debe tener un formato válido, por ejemplo: ABCD850101ABC',
            'rfc.unique' => 'Este RFC ya está registrado.',
            'rfc.required' => 'El campo RFC es obligatorio.',
            'rfc.max' => 'El RFC no puede tener más de 13 caracteres.',

            'genero.required' => 'Debe seleccionar al menos una opción.',

            'email.required' => 'El campo correo es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'Este correo ya está registrado.',



            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.numeric' => 'El teléfono debe ser un número.',
            'telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos.',



            'localidad_id.required' => 'Debe seleccionar una localidad.',

            'calle.required' => 'El campo calle es obligatorio.',
            'calle.string' => 'El campo calle debe ser una cadena de texto.',
            'calle.max' => 'La calle no puede tener más de 255 caracteres.',
            'colonia.required' => 'El campo colonia es obligatorio.',

            'colonia.string' => 'El campo colonia debe ser una cadena de texto.',
            'colonia.max' => 'La colonia no puede tener más de 255 caracteres.',

            'cp.required' => 'El campo código postal es obligatorio.',
            'cp.numeric' => 'El campo código postal debe ser numerico.',
        ];
    }



    public function mount()
    {
        $this->regions = Region::all();
        $this->municipios = Municipio::all();
    }

    public function updatedSelectedRegion()
    {
        $regionId = $this->selectedRegion;

        $this->delegacions = Delegacion::where('region_id', $regionId)
                                ->orderBy('deleg_delegacional', 'asc')
                                ->get();
        $this->selectedDelegacion = null;

        // Esto te ayuda a confirmar que entra aquí
        // $this->message = 'Región actualizada: ' . $regionId;
    }

    public function updatedSelectedMunicipio()
    {
        $municipioId = $this->selectedMunicipio;
        $this->localidades = Localidad::where('municipio_id', $municipioId)
                                ->orderBy('nombre', 'asc')
                                ->get();
        $this->localidad_id = null;
    }




        
    public function render()
    {
        return view('livewire.castilla-mujeres');
    }

    public function guardar()
    {

        $this->tema_id = 7; // Asignar un tema por defecto, si es necesario 
        $this->selectedTema = Tema::find($this->tema_id);

        
        // Validación
        $this->validate();

        // Generamos el slug
        $this->slug = Str::slug($this->nombre.'-'.$this->apaterno.'-'.$this->amaterno);

        // Generar folio único
        do {
            $folio = 'SNT56-' . date('Y') . '-' . Str::upper(Str::random(3)) . '-' . Str::upper(Str::random(8));
        } while (Participante::where('folio', $folio)->exists());


        // Si la opción es "no", asignamos valores por defecto
        if ($this->opcion === 'no') {
            $this->selectedRegion = 13; // Región por defecto
            $this->selectedDelegacion = 338; // Delegación por defecto
            $this->npersonal = 0; // Número de personal por defecto
            $this->nivel = 'Preescolar'; // Nivel por defecto
        }


        // dd($this);


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
            'ct' => 'empty',
            'cargo' => 'empty',
            'nivel' => $this->nivel,
            'curp' => 'empty',
            'folio' => $folio,
            'slug' => $this->slug,
            'codigo_id' => sprintf(
                "%04s-%04s-%04s-%04s",
                substr(uniqid(), 0, 4),
                substr(uniqid(), 4, 4),
                substr(uniqid(), 8, 4),
                substr(uniqid(), 12, 4)
            ),
            'localidad_id' => $this->localidad_id,
            'calle' => mb_strtoupper($this->calle, 'UTF-8'),
            'colonia' => mb_strtoupper($this->colonia, 'UTF-8'),
            'cp' => mb_strtoupper($this->cp, 'UTF-8'),
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
            'tema_id',
            'slug',
            'selectedMunicipio',
            'localidad_id',
            'calle',
            'colonia',
            'cp',
            'opcion',
        ]);
    }    
}
