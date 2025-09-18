<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Asset Information')
                    ->description('Basic asset identification and categorization')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        TextInput::make('asset_number')
                            ->label('Asset Number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->placeholder('AST-2024-001'),

                        TextInput::make('serial_number')
                            ->label('Serial Number')
                            ->maxLength(100)
                            ->placeholder('SN123456789'),

                        Select::make('category')
                            ->label('Category')
                            ->required()
                            ->options([
                                'laptop' => 'Laptop',
                                'desktop' => 'Desktop Computer',
                                'monitor' => 'Monitor',
                                'printer' => 'Printer',
                                'projector' => 'Projector',
                                'scanner' => 'Scanner',
                                'camera' => 'Camera',
                                'tablet' => 'Tablet',
                                'smartphone' => 'Smartphone',
                                'network' => 'Network Equipment',
                                'server' => 'Server',
                                'storage' => 'Storage Device',
                                'other' => 'Other Equipment',
                            ])
                            ->searchable(),

                        TextInput::make('brand')
                            ->label('Brand')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Dell, HP, Lenovo, etc.'),

                        TextInput::make('model')
                            ->label('Model')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Model number or name'),
                    ])
                    ->columns(2),

                Section::make('Purchase Information')
                    ->description('Purchase and warranty details')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        DatePicker::make('purchase_date')
                            ->label('Purchase Date')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),

                        DatePicker::make('warranty_expiry')
                            ->label('Warranty Expiry')
                            ->displayFormat('d/m/Y')
                            ->after('purchase_date'),

                        TextInput::make('purchase_value')
                            ->label('Purchase Value (RM)')
                            ->numeric()
                            ->prefix('RM')
                            ->step(0.01)
                            ->placeholder('0.00'),
                    ])
                    ->columns(3),

                Section::make('Status & Assignment')
                    ->description('Current status and assignment information')
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'available' => 'Available',
                                'assigned' => 'Assigned',
                                'maintenance' => 'Under Maintenance',
                                'retired' => 'Retired',
                                'lost' => 'Lost',
                                'damaged' => 'Damaged',
                            ])
                            ->default('available')
                            ->live(),

                        Select::make('condition')
                            ->label('Condition')
                            ->required()
                            ->options([
                                'excellent' => 'Excellent',
                                'good' => 'Good',
                                'fair' => 'Fair',
                                'poor' => 'Poor',
                                'damaged' => 'Damaged',
                            ])
                            ->default('excellent'),

                        TextInput::make('location')
                            ->label('Current Location')
                            ->maxLength(200)
                            ->placeholder('Building, Floor, Room'),

                        TextInput::make('assigned_to')
                            ->label('Assigned To')
                            ->maxLength(100)
                            ->placeholder('Staff name or department')
                            ->visible(fn ($get) => $get('status') === 'assigned'),

                        DatePicker::make('assigned_date')
                            ->label('Assignment Date')
                            ->displayFormat('d/m/Y')
                            ->maxDate(now())
                            ->visible(fn ($get) => $get('status') === 'assigned'),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->description('Additional notes and documentation')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->maxLength(1000)
                            ->rows(3)
                            ->placeholder('Detailed description of the asset'),

                        Textarea::make('notes')
                            ->label('Notes')
                            ->maxLength(1000)
                            ->rows(3)
                            ->placeholder('Additional notes, maintenance history, etc.'),
                    ])
                    ->columns(1),
            ]);
    }
}
