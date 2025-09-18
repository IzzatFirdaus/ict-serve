<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentItemResource\Pages;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Model;

class EquipmentItemResource extends Resource
{
    protected static ?string $model = null; // Will set this to actual model when available

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $navigationLabel = 'Equipment Items';

    protected static ?string $modelLabel = 'Equipment Item';

    protected static ?string $pluralModelLabel = 'Equipment Items';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        // TODO: Rebuild schema using Filament v4 Section/TextInput/Select/Textarea/DatePicker components from Filament\Schemas\Components
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to delete this equipment item? This action cannot be undone.')
                    ->modalIcon('heroicon-o-exclamation-triangle')
                    ->modalIconColor('danger'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
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
