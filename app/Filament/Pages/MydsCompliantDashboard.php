<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MydsCompliantDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.pages.myds-compliant-dashboard';
    
    protected static ?string $title = 'ICT Serve Dashboard';
    
    protected static ?string $navigationLabel = 'Dashboard';
    
    protected static ?int $navigationSort = 1;
    
    public function getHeading(): string
    {
        return 'ICT Serve - MYDS Compliant Admin Panel';
    }
    
    public function getSubheading(): string
    {
        return 'Malaysia Government Design System (MYDS) powered by Filament';
    }
    
    public function getTotalEquipment(): int
    {
        // Mock data for demonstration - replace with actual model queries
        return 157;
    }
    
    public function getActiveLoans(): int
    {
        // Mock data for demonstration - replace with actual model queries  
        return 23;
    }
    
    public function getOpenTickets(): int
    {
        // Mock data for demonstration - replace with actual model queries
        return 8;
    }
    
    public function getOverdueItems(): int
    {
        // Mock data for demonstration - replace with actual model queries
        return 3;
    }
}