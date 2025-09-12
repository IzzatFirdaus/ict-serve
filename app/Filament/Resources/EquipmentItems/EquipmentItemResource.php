<?php

namespace App\Filament\Resources\EquipmentItems;

use App\Filament\Resources\EquipmentItems\Pages\CreateEquipmentItem;
use App\Filament\Resources\EquipmentItems\Pages\EditEquipmentItem;
use App\Filament\Resources\EquipmentItems\Pages\ListEquipmentItems;
use App\Filament\Resources\EquipmentItems\Schemas\EquipmentItemForm;
use App\Filament\Resources\EquipmentItems\Tables\EquipmentItemsTable;
use App\Models\EquipmentItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EquipmentItemResource extends Resource
{
    protected static ?string $model = EquipmentItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static ?string $navigationLabel = 'Equipment';

    protected static ?string $modelLabel = 'Equipment Item';

    protected static ?string $pluralModelLabel = 'Equipment Items';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return EquipmentItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EquipmentItemsTable::configure($table);
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
            'index' => ListEquipmentItems::route('/'),
            'create' => CreateEquipmentItem::route('/create'),
            'edit' => EditEquipmentItem::route('/{record}/edit'),
        ];
    }
}
