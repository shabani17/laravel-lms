<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Hamid',
            'email' => 'hamid@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'email' => 'hamid@test.com',
        ]);
        
        $response->assertJsonStructure([
            'message',
            'data'=> [
                'user',
                'token',
            ]
        ]);
    }

    public function test_user_cannot_register_with_existing_email(): void
    {
        $this->postJson('/api/register', [
            'name' => 'Hamid',
            'email' => 'hamid@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Another User',
            'email' => 'hamid@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertUnprocessable();
    }
}