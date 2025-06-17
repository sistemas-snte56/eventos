<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Region;
use Filament\Forms\Form;
use App\Models\Delegacion;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DelegacionResource\Pages;
use App\Filament\Resources\DelegacionResource\RelationManagers;

class DelegacionResource extends Resource
{
    protected static ?string $model = Delegacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Regiones')
                    ->description('Ingresa los datos para la nueva delegación')
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
                            ->required(),

                        TextInput::make('deleg_delegacional')
                            ->label('Delegación')
                            ->required()
                            ->maxLength(255),

                        Select::make('nivel_delegacional')
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
                            
                        TextInput::make('sede_delegacional')
                            ->label('Sede')
                            ->required()
                            ->maxLength(255),
                                                        
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('deleg_delegacional')
                    ->label('Delegación')
                    ->sortable('deleg_delegacional')
                    ->searchable(),
                TextColumn::make('nivel_delegacional')
                    ->label('Nivel Delegacional'),
                TextColumn::make('sede_delegacional')
                    ->label('Sede')
                    ->searchable(),
                TextColumn::make('region.region')
                    ->label('Región')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->region?->region . ' - ' . $record->region?->sede;
                    })
                    ->searchable()
                    ->sortable(),                   
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
            'index' => Pages\ListDelegacions::route('/'),
            'create' => Pages\CreateDelegacion::route('/create'),
            'edit' => Pages\EditDelegacion::route('/{record}/edit'),
        ];
    }
}
