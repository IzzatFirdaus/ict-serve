<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        // Basic sanity: ensure the User model class exists in the app
        $this->assertTrue(class_exists(\App\Models\User::class));
    }
}
