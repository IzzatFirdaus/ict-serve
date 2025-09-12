<?php

namespace App\Filament\Resources\DamageComplaints;

use App\Filament\Resources\DamageComplaints\Pages\CreateDamageComplaint;
use App\Filament\Resources\DamageComplaints\Pages\EditDamageComplaint;
use App\Filament\Resources\DamageComplaints\Pages\ListDamageComplaints;
use App\Filament\Resources\DamageComplaints\Schemas\DamageComplaintForm;
use App\Filament\Resources\DamageComplaints\Tables\DamageComplaintsTable;
use App\Models\DamageComplaint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DamageComplaintResource extends Resource
{
    protected static ?string $model = DamageComplaint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DamageComplaintForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DamageComplaintsTable::configure($table);
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
            'index' => ListDamageComplaints::route('/'),
            'create' => CreateDamageComplaint::route('/create'),
            'edit' => EditDamageComplaint::route('/{record}/edit'),
        ];
    }
}
