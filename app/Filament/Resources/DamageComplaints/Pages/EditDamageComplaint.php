<?php

namespace App\Filament\Resources\DamageComplaints\Pages;

use App\Filament\Resources\DamageComplaints\DamageComplaintResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDamageComplaint extends EditRecord
{
    protected static string $resource = DamageComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
