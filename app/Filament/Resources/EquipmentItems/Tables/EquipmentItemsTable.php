<?php

namespace App\Filament\Resources\EquipmentItems\Tables;

use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class EquipmentItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_tag')
                    ->label('Asset Tag')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('brand')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (EquipmentStatus $state): string => $state->color()),

                TextColumn::make('condition')
                    ->badge()
                    ->color(fn (EquipmentCondition $state): string => $state->color()),

                TextColumn::make('location')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('Not specified'),

                TextColumn::make('purchase_price')
                    ->label('Price')
                    ->money('MYR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('warranty_status')
                    ->label('Warranty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Under Warranty' => 'success',
                        'Warranty Expired' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->preload(),

                SelectFilter::make('status')
                    ->options(EquipmentStatus::class)
                    ->native(false),

                SelectFilter::make('condition')
                    ->options(EquipmentCondition::class)
                    ->native(false),

                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All equipment')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->searchPlaceholder('Search by asset tag, brand, model, or location...');
    }
}
