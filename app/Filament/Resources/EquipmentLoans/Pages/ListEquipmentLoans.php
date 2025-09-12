<?php

namespace App\Filament\Resources\EquipmentLoans\Pages;

use App\Filament\Resources\EquipmentLoans\EquipmentLoanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentLoans extends ListRecords
{
    protected static string $resource = EquipmentLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
