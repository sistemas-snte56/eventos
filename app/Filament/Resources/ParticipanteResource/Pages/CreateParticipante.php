<?php

namespace App\Filament\Resources\ParticipanteResource\Pages;

use App\Filament\Resources\ParticipanteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

use Illuminate\Support\Str;
use App\Models\Participante;

class CreateParticipante extends CreateRecord
{
    protected static string $resource = ParticipanteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Slug
        $data['slug'] = Str::slug($data['nombre'] . '-' . $data['apaterno'] . '-' . $data['amaterno']);

        // Folio único
        do {
            $folio = 'SNT56-' . date('Y') . '-' . Str::upper(Str::random(3)) . '-' . Str::upper(Str::random(8));
        } while (Participante::where('folio', $folio)->exists());

        $data['folio'] = $folio;

        // Código ID
        $data['codigo_id'] = sprintf(
            "%04s-%04s-%04s-%04s",
            substr(uniqid(), 0, 4),
            substr(uniqid(), 4, 4),
            substr(uniqid(), 8, 4),
            substr(uniqid(), 12, 4)
        );

        // Uppercase
        $data['rfc'] = mb_strtoupper($data['rfc'], 'UTF-8');
        $data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');
        $data['apaterno'] = mb_strtoupper($data['apaterno'], 'UTF-8');
        $data['amaterno'] = mb_strtoupper($data['amaterno'], 'UTF-8');

        return $data;
    }    

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            // ->title('Participante creado')
            // ->success()
            // ->body('El participante ha sido creado exitosamente.')
            // ->actions([
            //     Actions\Action::make('Ver participante')
            //         ->url(fn (CreateRecord $record): string => $record->getResource()::getUrl('view', ['record' => $record->getRecord()])),
            // ]);
        ->success()
        ->title('Participante creado')
        ->body("Folio generado: <br><strong>{$this->record->folio}</strong>")
        ->persistent() // Se mantiene visible hasta que el usuario la cierre
        ->duration(7000); // Visible por 7 segundos            
    }

        
}
