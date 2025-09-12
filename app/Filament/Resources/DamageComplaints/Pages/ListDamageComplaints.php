<?php

namespace App\Filament\Resources\DamageComplaints\Pages;

use App\Filament\Resources\DamageComplaints\DamageComplaintResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDamageComplaints extends ListRecords
{
    protected static string $resource = DamageComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
