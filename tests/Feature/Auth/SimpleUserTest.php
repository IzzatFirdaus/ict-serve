<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SimpleUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation_directly(): void
    {
        // Create user directly
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertNotNull($user);
        $this->assertEquals('test@example.com', $user->email);

        // Try to log in the user
        Auth::login($user);

        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
    }
}
