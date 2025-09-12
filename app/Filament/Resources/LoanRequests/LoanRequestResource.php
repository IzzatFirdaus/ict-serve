<?php

namespace App\Filament\Resources\LoanRequests;

use App\Filament\Resources\LoanRequests\Pages\CreateLoanRequest;
use App\Filament\Resources\LoanRequests\Pages\EditLoanRequest;
use App\Filament\Resources\LoanRequests\Pages\ListLoanRequests;
use App\Filament\Resources\LoanRequests\Schemas\LoanRequestForm;
use App\Filament\Resources\LoanRequests\Tables\LoanRequestsTable;
use App\Models\LoanRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoanRequestResource extends Resource
{
    protected static ?string $model = LoanRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Loan Requests';

    protected static ?string $modelLabel = 'Loan Request';

    protected static ?string $pluralModelLabel = 'Loan Requests';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return LoanRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoanRequestsTable::configure($table);
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
            'index' => ListLoanRequests::route('/'),
            'create' => CreateLoanRequest::route('/create'),
            'edit' => EditLoanRequest::route('/{record}/edit'),
        ];
    }
}
