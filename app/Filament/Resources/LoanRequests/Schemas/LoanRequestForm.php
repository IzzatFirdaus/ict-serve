<?php

namespace App\Filament\Resources\LoanRequests\Schemas;

use App\Enums\LoanRequestStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LoanRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference_number')
                    ->default(null),
                TextInput::make('request_number')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('applicant_name')
                    ->default(null),
                TextInput::make('applicant_position')
                    ->default(null),
                TextInput::make('applicant_department')
                    ->default(null),
                TextInput::make('applicant_phone')
                    ->tel()
                    ->default(null),
                TextInput::make('status_id')
                    ->required()
                    ->numeric(),
                Textarea::make('purpose')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('location')
                    ->default(null),
                DatePicker::make('requested_from')
                    ->required(),
                DatePicker::make('loan_start_date'),
                DatePicker::make('expected_return_date'),
                TextInput::make('responsible_officer_name')
                    ->default(null),
                TextInput::make('responsible_officer_position')
                    ->default(null),
                TextInput::make('responsible_officer_phone')
                    ->tel()
                    ->default(null),
                Toggle::make('same_as_applicant')
                    ->required(),
                Textarea::make('equipment_requests')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('endorsing_officer_name')
                    ->default(null),
                TextInput::make('endorsing_officer_position')
                    ->default(null),
                TextInput::make('endorsement_status')
                    ->default(null),
                Textarea::make('endorsement_comments')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(LoanRequestStatus::class)
                    ->default('pending_bpm_review')
                    ->required(),
                DateTimePicker::make('submitted_at'),
                DatePicker::make('requested_to')
                    ->required(),
                DatePicker::make('actual_from'),
                DatePicker::make('actual_to'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('rejection_reason')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('supervisor_id')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('supervisor_approved_at'),
                Textarea::make('supervisor_notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('ict_admin_id')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('ict_approved_at'),
                Textarea::make('ict_notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('issued_by')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('issued_at'),
                TextInput::make('pickup_signature_path')
                    ->default(null),
                TextInput::make('received_by')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('returned_at'),
                TextInput::make('return_signature_path')
                    ->default(null),
                Textarea::make('return_condition_notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
