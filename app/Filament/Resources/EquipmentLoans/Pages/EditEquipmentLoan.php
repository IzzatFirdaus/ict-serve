<?php

namespace App\Filament\Resources\EquipmentLoans\Pages;

use App\Filament\Resources\EquipmentLoans\EquipmentLoanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentLoan extends EditRecord
{
    protected static string $resource = EquipmentLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
