<?php

use Illuminate\Support\Facades\Route;

// Basic route for testing
Route::get('/', function () {
    return 'Laravel with Filament is running!';
});

// Test route to create an admin user
Route::get('/create-admin', function () {
    if (!\App\Models\User::where('email', 'admin@ict.gov.my')->exists()) {
        \App\Models\User::create([
            'name' => 'ICT Admin',
            'email' => 'admin@ict.gov.my',
            'password' => bcrypt('admin123'),
        ]);
        return 'Admin user created! Email: admin@ict.gov.my, Password: admin123';
    }
    return 'Admin user already exists!';
});