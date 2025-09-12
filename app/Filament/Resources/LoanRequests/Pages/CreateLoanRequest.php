<?php

namespace App\Filament\Resources\LoanRequests\Pages;

use App\Filament\Resources\LoanRequests\LoanRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLoanRequest extends CreateRecord
{
    protected static string $resource = LoanRequestResource::class;
}
