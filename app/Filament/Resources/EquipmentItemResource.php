<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentItemResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EquipmentItemResource extends Resource
{
    protected static ?string $model = null; // Will set this to actual model when available
    
    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    
    protected static ?string $navigationLabel = 'Equipment Items';
    
    protected static ?string $modelLabel = 'Equipment Item';
    
    protected static ?string $pluralModelLabel = 'Equipment Items';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // MYDS-compliant form fields with comprehensive validation
                Forms\Components\Section::make('Equipment Details')
                    ->description('Enter the basic information about the equipment item')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Equipment Name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Enter the official name or model of the equipment')
                            ->validationMessages([
                                'required' => 'Equipment name is required for identification.',
                                'max' => 'Equipment name cannot exceed 255 characters.',
                            ]),
                            
                        Forms\Components\TextInput::make('serial_number')
                            ->label('Serial Number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->helperText('Unique identifier for this equipment item')
                            ->validationMessages([
                                'required' => 'Serial number is required for tracking.',
                                'unique' => 'This serial number is already registered in the system.',
                                'max' => 'Serial number cannot exceed 100 characters.',
                            ]),
                            
                        Forms\Components\Select::make('category_id')
                            ->label('Equipment Category')
                            ->required()
                            ->options([
                                1 => 'Laptop',
                                2 => 'Desktop Computer',
                                3 => 'Monitor',
                                4 => 'Printer',
                                5 => 'Network Equipment',
                                6 => 'Mobile Device',
                                7 => 'Audio/Visual Equipment',
                            ])
                            ->helperText('Select the appropriate category for this equipment')
                            ->validationMessages([
                                'required' => 'Please select an equipment category.',
                            ]),
                            
                        Forms\Components\Select::make('status')
                            ->label('Equipment Status')
                            ->required()
                            ->options([
                                'available' => 'Available',
                                'loaned' => 'On Loan',
                                'maintenance' => 'Under Maintenance',
                                'damaged' => 'Damaged',
                                'retired' => 'Retired',
                            ])
                            ->default('available')
                            ->helperText('Current status of the equipment')
                            ->validationMessages([
                                'required' => 'Please select the current equipment status.',
                            ]),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Technical Specifications')
                    ->description('Detailed technical information about the equipment')
                    ->schema([
                        Forms\Components\Textarea::make('specifications')
                            ->label('Technical Specifications')
                            ->rows(4)
                            ->maxLength(1000)
                            ->helperText('Enter detailed technical specifications (max 1000 characters)')
                            ->validationMessages([
                                'max' => 'Specifications cannot exceed 1000 characters.',
                            ]),
                            
                        Forms\Components\TextInput::make('purchase_price')
                            ->label('Purchase Price (RM)')
                            ->numeric()
                            ->prefix('RM')
                            ->minValue(0)
                            ->maxValue(999999.99)
                            ->helperText('Original purchase price of the equipment')
                            ->validationMessages([
                                'numeric' => 'Please enter a valid price amount.',
                                'min' => 'Price cannot be negative.',
                                'max' => 'Price cannot exceed RM 999,999.99.',
                            ]),
                            
                        Forms\Components\DatePicker::make('purchase_date')
                            ->label('Purchase Date')
                            ->maxDate(now())
                            ->helperText('Date when the equipment was purchased')
                            ->validationMessages([
                                'max' => 'Purchase date cannot be in the future.',
                            ]),
                            
                        Forms\Components\TextInput::make('warranty_months')
                            ->label('Warranty Period (Months)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(120)
                            ->helperText('Warranty period in months')
                            ->validationMessages([
                                'numeric' => 'Please enter a valid number of months.',
                                'min' => 'Warranty period cannot be negative.',
                                'max' => 'Warranty period cannot exceed 120 months (10 years).',
                            ]),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Location & Assignment')
                    ->description('Physical location and assignment information')
                    ->schema([
                        Forms\Components\TextInput::make('location')
                            ->label('Current Location')
                            ->maxLength(255)
                            ->helperText('Building, floor, and room where equipment is located'),
                            
                        Forms\Components\Select::make('assigned_to')
                            ->label('Assigned To')
                            ->searchable()
                            ->options([
                                // Mock data - replace with actual User query
                                1 => 'Ahmad Rahman (ICT Department)',
                                2 => 'Siti Nurhaliza (Finance Department)',  
                                3 => 'Mohamed Ali (HR Department)',
                            ])
                            ->helperText('User currently assigned to this equipment'),
                            
                        Forms\Components\Textarea::make('notes')
                            ->label('Additional Notes')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Any additional information about this equipment')
                            ->validationMessages([
                                'max' => 'Notes cannot exceed 500 characters.',
                            ]),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // MYDS-compliant table columns
                Tables\Columns\TextColumn::make('serial_number')
                    ->label('Serial Number')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Equipment Name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                    
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->badge(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'loaned' => 'warning', 
                        'maintenance' => 'info',
                        'damaged' => 'danger',
                        'retired' => 'gray',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('assigned_to_name')
                    ->label('Assigned To')
                    ->searchable()
                    ->limit(25),
                    
                Tables\Columns\TextColumn::make('purchase_date')
                    ->label('Purchase Date')
                    ->date('d M Y')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('d M Y, g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'loaned' => 'On Loan',
                        'maintenance' => 'Under Maintenance', 
                        'damaged' => 'Damaged',
                        'retired' => 'Retired',
                    ]),
                    
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to delete this equipment item? This action cannot be undone.')
                    ->modalIcon('heroicon-o-exclamation-triangle')
                    ->modalIconColor('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalDescription('Are you sure you want to delete the selected equipment items? This action cannot be undone.'),
                ]),
            ])
            ->emptyStateHeading('No Equipment Items Found')
            ->emptyStateDescription('Start by adding your first equipment item to the system.')
            ->emptyStateIcon('heroicon-o-computer-desktop');
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
            'index' => Pages\ListEquipmentItems::route('/'),
            'create' => Pages\CreateEquipmentItem::route('/create'),
            'view' => Pages\ViewEquipmentItem::route('/{record}'),
            'edit' => Pages\EditEquipmentItem::route('/{record}/edit'),
        ];
    }
    
    // Mock data methods for demonstration
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Return empty query for demonstration - replace with actual model query
        return \Illuminate\Database\Eloquent\Builder::from('equipment_items');
    }
}