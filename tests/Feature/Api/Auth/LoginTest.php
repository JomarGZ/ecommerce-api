<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use LazilyRefreshDatabase;

    private function submitLogin($override = [])
    {
        $defaults = [
            'email' => 'user@example.com',
            'password' => 'password'
        ];
        return $this->postJson('api/auth/login', array_merge($defaults, $override));
    }
    /**
     * A basic feature test example.
     */
    public function test_can_login(): void
    {
        User::factory()->create(['email' => 'user@example.com']);

        $response = $this->submitLogin();

        $response->assertStatus(Response::HTTP_OK);
        $Token = $response->json('data.access_token');
        $this->assertNotNull($Token);
    }

    public function test_email_is_required()
    {
        $response = $this->submitLogin(['email' => '']);

        $this->AssertValidationError($response, 'email');
    }
    public function test_email_is_email()
    {
        $response = $this->submitLogin(['email' => 'notemail']);

        $this->AssertValidationError($response, 'email');
    }
    public function test_password_is_required()
    {
        $response = $this->submitLogin(['password' => '']);

        $this->AssertValidationError($response, 'password');
    }

}
