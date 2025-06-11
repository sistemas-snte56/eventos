<?php

namespace App\Filament\Resources\ParticipanteResource\Pages;

use App\Filament\Resources\ParticipanteResource;
use Filament\Resources\Pages\Page;

class ImportParticipantes extends Page
{
    protected static string $resource = ParticipanteResource::class;

    protected static string $view = 'filament.resources.participante-resource.pages.import-participantes';
}
