<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_number')
                    ->label('Asset Number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('category')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'laptop' => 'primary',
                        'desktop' => 'secondary',
                        'monitor' => 'success',
                        'printer' => 'warning',
                        'server' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('brand')
                    ->label('Brand')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model')
                    ->label('Model')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'available',
                        'primary' => 'assigned',
                        'warning' => 'maintenance',
                        'gray' => 'retired',
                        'danger' => ['lost', 'damaged'],
                    ]),

                BadgeColumn::make('condition')
                    ->label('Condition')
                    ->colors([
                        'success' => 'excellent',
                        'primary' => 'good',
                        'warning' => 'fair',
                        'danger' => ['poor', 'damaged'],
                    ]),

                TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->limit(25)
                    ->placeholder('Not assigned'),

                TextColumn::make('assigned_to')
                    ->label('Assigned To')
                    ->searchable()
                    ->limit(25)
                    ->placeholder('Unassigned'),

                TextColumn::make('purchase_value')
                    ->label('Value')
                    ->money('MYR')
                    ->sortable(),

                TextColumn::make('purchase_date')
                    ->label('Purchase Date')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('warranty_expiry')
                    ->label('Warranty')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($state) => $state && $state->isPast() ? 'danger' : 'success'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'assigned' => 'Assigned',
                        'maintenance' => 'Under Maintenance',
                        'retired' => 'Retired',
                        'lost' => 'Lost',
                        'damaged' => 'Damaged',
                    ])
                    ->multiple(),

                SelectFilter::make('category')
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
                    ->multiple(),

                SelectFilter::make('condition')
                    ->options([
                        'excellent' => 'Excellent',
                        'good' => 'Good',
                        'fair' => 'Fair',
                        'poor' => 'Poor',
                        'damaged' => 'Damaged',
                    ])
                    ->multiple(),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make()
                    ->color('secondary'),
                EditAction::make()
                    ->color('primary'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
