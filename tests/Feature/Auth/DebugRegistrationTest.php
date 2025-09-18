<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DebugRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_debug_registration(): void
    {
        // Check if register route works
        $getResponse = $this->get('/register');
        $this->assertEquals(200, $getResponse->status(), 'Register page should load');

        // Attempt registration
        try {
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);
        } catch (\Exception $e) {
            dump('Exception during registration: '.$e->getMessage());
            dump('Exception trace: '.$e->getTraceAsString());
            throw $e;
        }

        // Debug the response
        dump('Response status: '.$response->status());

        // Check if user was created
        $user = User::where('email', 'test@example.com')->first();
        dump('User created: '.($user ? 'Yes' : 'No'));

        if ($user) {
            dump('User ID: '.$user->id);
            dump('User name: '.$user->name);
        }

        // Check authentication state
        dump('Auth check: '.(Auth::check() ? 'true' : 'false'));
        dump('Auth guard: '.Auth::getDefaultDriver());
        dump('Auth user ID: '.(Auth::id() ?: 'null'));

        // Check session
        dump('Session ID: '.session()->getId());
        dump('Session data: ', session()->all());

        // Check response details
        if ($response->status() === 302) {
            dump('Redirect location: '.$response->headers->get('Location'));
        }

        dump('Auth user: ', Auth::user());

        // Response content for debugging
        if ($response->status() !== 302) {
            dump('Response content (first 500 chars): '.substr($response->content(), 0, 500));
        }

        // Final assertion
        $this->assertTrue(true, 'Debug test completed');
    }
}
