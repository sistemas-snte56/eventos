<?php

namespace App\Filament\Resources\DelegacionResource\Pages;

use App\Filament\Resources\DelegacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDelegacions extends ListRecords
{
    protected static string $resource = DelegacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
