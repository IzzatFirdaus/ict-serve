<?php

declare(strict_types=1);

namespace Tests\Feature;

// Framework
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

// Application Models

// Application Services

// Application Notifications

class LoanApplicationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * Lightweight schema & model sanity check for loan application tables.
     */
    public function test_loan_tables_and_models_exist(): void
    {
        // Ensure migrations ran and tables exist
        $this->assertTrue(Schema::hasTable('loan_requests'), 'Table loan_requests does not exist');
        $this->assertTrue(Schema::hasTable('loan_items'), 'Table loan_items does not exist');

        // Ensure model classes exist
        $this->assertTrue(class_exists(\App\Models\LoanRequest::class), 'Model App\\Models\\LoanRequest not found');
        $this->assertTrue(class_exists(\App\Models\LoanItem::class), 'Model App\\Models\\LoanItem not found');
    }
}
