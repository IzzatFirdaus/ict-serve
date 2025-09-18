<?php

namespace App\Filament\Resources\LoanRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LoanRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')
                    ->searchable(),
                TextColumn::make('request_number')
                    ->searchable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('applicant_name')
                    ->searchable(),
                TextColumn::make('applicant_position')
                    ->searchable(),
                TextColumn::make('applicant_department')
                    ->searchable(),
                TextColumn::make('applicant_phone')
                    ->searchable(),
                TextColumn::make('status_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('requested_from')
                    ->date()
                    ->sortable(),
                TextColumn::make('loan_start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('expected_return_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('responsible_officer_name')
                    ->searchable(),
                TextColumn::make('responsible_officer_position')
                    ->searchable(),
                TextColumn::make('responsible_officer_phone')
                    ->searchable(),
                IconColumn::make('same_as_applicant')
                    ->boolean(),
                TextColumn::make('endorsing_officer_name')
                    ->searchable(),
                TextColumn::make('endorsing_officer_position')
                    ->searchable(),
                TextColumn::make('endorsement_status')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('requested_to')
                    ->date()
                    ->sortable(),
                TextColumn::make('actual_from')
                    ->date()
                    ->sortable(),
                TextColumn::make('actual_to')
                    ->date()
                    ->sortable(),
                TextColumn::make('supervisor_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('supervisor_approved_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ict_admin_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ict_approved_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('issued_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('issued_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('pickup_signature_path')
                    ->searchable(),
                TextColumn::make('received_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('returned_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('return_signature_path')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
