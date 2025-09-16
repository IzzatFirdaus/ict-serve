<?php

namespace App\Filament\Resources\HelpdeskTickets\Schemas;

use App\Enums\TicketPriority;
use App\Enums\TicketUrgency;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HelpdeskTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ticket_number')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('status_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('damage_type')
                    ->default(null),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                Select::make('priority')
                    ->options(TicketPriority::class)
                    ->default('medium')
                    ->required(),
                Select::make('urgency')
                    ->options(TicketUrgency::class)
                    ->default('medium')
                    ->required(),
                TextInput::make('assigned_to')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('assigned_at'),
                TextInput::make('equipment_item_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('location')
                    ->default(null),
                TextInput::make('contact_phone')
                    ->tel()
                    ->default(null),
                DateTimePicker::make('due_at'),
                DateTimePicker::make('resolved_at'),
                DateTimePicker::make('closed_at'),
                Textarea::make('resolution')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('resolution_notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('resolved_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('satisfaction_rating')
                    ->numeric()
                    ->default(null),
                Textarea::make('feedback')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('attachments')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
