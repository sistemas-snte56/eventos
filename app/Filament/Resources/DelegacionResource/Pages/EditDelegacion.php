<?php

namespace App\Filament\Resources\DelegacionResource\Pages;

use App\Filament\Resources\DelegacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDelegacion extends EditRecord
{
    protected static string $resource = DelegacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
