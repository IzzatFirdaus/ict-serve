<?php

namespace App\Filament\Resources\EquipmentItems\Schemas;

use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use App\Models\EquipmentCategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EquipmentItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Essential equipment details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required(),
                                        Textarea::make('description'),
                                        TextInput::make('color')
                                            ->label('Color (Hex)')
                                            ->prefix('#'),
                                        TextInput::make('icon')
                                            ->label('Icon (Heroicon)')
                                            ->helperText('e.g., computer-desktop'),
                                        Toggle::make('is_active')
                                            ->default(true),
                                    ]),

                                TextInput::make('asset_tag')
                                    ->label('Asset Tag')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->prefixIcon('heroicon-o-tag')
                                    ->placeholder('e.g., AST001'),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('brand')
                                    ->required()
                                    ->placeholder('e.g., Dell, HP, Lenovo'),

                                TextInput::make('model')
                                    ->required()
                                    ->placeholder('e.g., Latitude 5520'),

                                TextInput::make('serial_number')
                                    ->label('Serial Number')
                                    ->placeholder('e.g., ABC123DEF456'),
                            ]),
                    ]),

                Section::make('Status & Condition')
                    ->description('Current status and condition of the equipment')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('status')
                                    ->options(EquipmentStatus::class)
                                    ->default(EquipmentStatus::AVAILABLE)
                                    ->required()
                                    ->native(false),

                                Select::make('condition')
                                    ->options(EquipmentCondition::class)
                                    ->default(EquipmentCondition::EXCELLENT)
                                    ->required()
                                    ->native(false),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Uncheck to hide from loan requests'),
                            ]),
                    ]),

                Section::make('Purchase Information')
                    ->description('Purchase and warranty details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('purchase_price')
                                    ->label('Purchase Price (RM)')
                                    ->numeric()
                                    ->prefix('RM')
                                    ->step(0.01),

                                DatePicker::make('purchase_date')
                                    ->label('Purchase Date')
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(today()),

                                DatePicker::make('warranty_expiry')
                                    ->label('Warranty Expiry')
                                    ->displayFormat('d/m/Y')
                                    ->minDate(today()),
                            ]),
                    ]),

                Section::make('Additional Details')
                    ->description('Technical specifications and notes')
                    ->schema([
                        Textarea::make('specifications')
                            ->label('Technical Specifications')
                            ->placeholder('CPU: Intel i5, RAM: 8GB, Storage: 256GB SSD...')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Additional description or features...')
                            ->rows(2)
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('location')
                                    ->label('Current Location')
                                    ->placeholder('e.g., ICT Office, Room 101'),

                                Textarea::make('notes')
                                    ->label('Internal Notes')
                                    ->placeholder('Any internal notes for staff...')
                                    ->rows(2),
                            ]),
                    ]),
            ]);
    }
}
