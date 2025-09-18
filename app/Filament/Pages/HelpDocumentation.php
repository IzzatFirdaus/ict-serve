<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class HelpDocumentation extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected string $view = 'filament.pages.help-documentation';

    protected static ?string $title = 'Help & Documentation';

    protected static ?string $navigationLabel = 'Help & Guides';

    protected static ?int $navigationSort = 99;

    protected static \UnitEnum|string|null $navigationGroup = 'Support';

    public function getHeading(): string
    {
        return 'Panduan dan Dokumentasi';
    }

    public function getSubheading(): string
    {
        return 'Comprehensive user guides and system documentation - MyGOVEA Principle Compliance';
    }
}
