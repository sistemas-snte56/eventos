<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Tema;
use Filament\Tables;
use App\Models\Region;


use Filament\Forms\Form;
use App\Models\Delegacion;


use Filament\Tables\Table;
use App\Models\Participante;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ParticipanteResource\Pages;
use App\Filament\Resources\ParticipanteResource\RelationManagers;

class ParticipanteResource extends Resource
{
    protected static ?string $model = Participante::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {



        return $form->schema([

            Section::make('Informacion delegacional')
                ->description('Datos delegacionales del participante')
                ->schema([
                    Select::make('region_id')
                        ->label('Región')
                        ->options(
                            Region::all()
                                ->sortBy('id')
                                ->mapWithKeys(fn ($region) => [
                                    $region->id => "{$region->region} - {$region->sede}"
                                ])
                        )
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('delegacion_id', null)),

                    Select::make('delegacion_id')
                        ->label('Delegación')
                        ->options(function (callable $get) {
                            $regionId = $get('region_id');

                            if (!$regionId) {
                                return [];
                            }

                            return Delegacion::where('region_id', $regionId)
                                ->orderBy('deleg_delegacional')
                                ->get()
                                ->mapWithKeys(fn ($d) => [
                                    $d->id => "{$d->deleg_delegacional} - {$d->sede_delegacional}"
                                ]);
                        })
                        ->required()
                        ->searchable(),                       
                        
                ]),

            Section::make('Información personal')
                ->description('Datos generales del participante')
                ->schema([

                    Grid::make()
                        ->columns([
                            'default' => 1,
                            'md' => 3, // nombre, apaterno, amaterno en la misma fila
                        ])
                        ->schema([
                            TextInput::make('nombre')
                                ->label('Nombre')
                                ->placeholder('Ingrese el nombre')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('apaterno')
                                ->label('Primer apellido')
                                ->placeholder('Apellido paterno')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('amaterno')
                                ->label('Segundo apellido')
                                ->placeholder('Apellido materno')
                                ->maxLength(255),
                        ]),

                    Grid::make()
                        ->columns([
                            'default' => 1,
                            'md' => 2,
                        ])
                        ->schema([
                            TextInput::make('rfc')
                                ->label('RFC')
                                ->placeholder('Ingrese el RFC')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true, column: 'rfc'),

                            Select::make('genero')
                                ->label('Género')
                                ->options([
                                    'Hombre' => 'Hombre',
                                    'Mujer' => 'Mujer',
                                ])
                                ->required(),
                        ]),

                    Grid::make()
                        ->columns([
                            'default' => 1,
                            'md' => 2,
                        ])
                        ->schema([
                            TextInput::make('email')
                                ->label('Correo electrónico')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true, column: 'email')
                                ->rules(['required', 'email', 'max:255'])
                                ->validationAttribute('Correo electrónico')  // Nombre amigable en mensajes
                                ->validationMessages([
                                    'required' => 'El :attribute es obligatorio.',
                                    'email' => 'Debe ser un correo válido.',
                                    'max' => 'El :attribute no puede tener más de :max caracteres.',
                                ]),                                

                            TextInput::make('npersonal')
                                ->label('Número personal')
                                ->numeric()
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true, column: 'npersonal'),
                        ]),

                    TextInput::make('telefono')
                        ->label('Teléfono')
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                        ->maxLength(255),
                ]),

            Section::make('Datos académicos')
                ->schema([
                    Select::make('nivel')
                        ->label('Nivel educativo')
                        ->options([
                            'Preescolar' => 'Preescolar',
                            'Primaria' => 'Primaria',
                            'Educación Especial' => 'Educación Especial',
                            'Secundaria' => 'Secundaria',
                            'Telesecundaria' => 'Telesecundaria',
                            'Educación Física' => 'Educación Física',
                            'Niveles Especiales' => 'Niveles Especiales',
                            'Paae' => 'Paae',
                            'Bachillerato' => 'Bachillerato',
                            'Telebachillerato' => 'Telebachillerato',
                            'Normales' => 'Normales',
                            'UPV' => 'UPV',
                            'Jubilados' => 'Jubilados',
                        ])
                        ->searchable()
                        ->required(),
                ]),

            Section::make('Temas del curso')
                ->schema([
                    CheckboxList::make('temas')
                        ->relationship('temas', 'titulo')
                        ->columns([
                            'default' => 1,
                            'md' => 3, // 3 columnas en desktop
                        ])
                        ->searchable()
                        ->label('Temas')
                        ->columnSpanFull()
                        ->required()
                ])
                ->collapsible()
                ->collapsed(false), // Puedes ponerlo en true si quieres que inicie cerrado

        ]);




    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('apaterno')
                    ->label('Apellido Paterno')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amaterno')
                    ->label('Apellido Materno')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('npersonal')
                    ->label('Número Personal')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('rfc')
                    ->label('RFC')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipantes::route('/'),
            'create' => Pages\CreateParticipante::route('/create'),
            'edit' => Pages\EditParticipante::route('/{record}/edit'),
        ];
    }
}
