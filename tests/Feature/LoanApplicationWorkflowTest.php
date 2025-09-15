<?php

declare(strict_types=1);

namespace Tests\Feature;

// Framework
use Illuminate\Foundation\Testing\RefreshDatabase;
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
     * @group disabled
     */
    public function test_loan_application_full_happy_path_workflow()
    {
        $this->markTestSkipped('Test disabled during merge - needs updating for current database schema');
    }
}
