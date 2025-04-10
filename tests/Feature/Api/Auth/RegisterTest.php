<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use LazilyRefreshDatabase;
    
    private function submitUserData(array $override = []): TestResponse
    {
        $defaults = [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        return $this->postJson('api/auth/register', array_merge($defaults, $override));
    }
    public function test_can_register_for_customer(): void
    {

        $response = $this->submitUserData();

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas(User::class, ['email' => 'test@example.com']);
        $token = $response->json('data.access_token');
        $this->assertNotNull($token);
    }

    public function test_name_is_required()
    {
        $response = $this->submitUserData(['name' => '']);

      $this->AssertValidationError($response, 'name');
    }
    public function test_name_is_string()
    {
        $response = $this->submitUserData(['name' => 323133]);

        $this->AssertValidationError($response, 'name');
    }
    public function test_name_is_min_3_characters()
    {
        $response = $this->submitUserData(['name' => 'a']);

        $this->AssertValidationError($response, 'name');
    }
    public function test_name_is_max_30_characters()
    {
        $response = $this->submitUserData(['name' => Str::repeat('a', 31)]);

        $this->AssertValidationError($response, 'name');
    }
    public function test_email_is_required()
    {
        $response = $this->submitUserData(['email' => '']);

        $this->AssertValidationError($response, 'email');
    }
    public function test_email_is_email()
    {
        $response = $this->submitUserData(['email' => 'notemail']);

        $this->AssertValidationError($response, 'email');
    }
    public function test_email_is_unique()
    {
        User::factory()->create(['email' => 'unique@example.com']);
        $response = $this->submitUserData(['email' => 'unique@example.com']);

        $this->AssertValidationError($response, 'email');
    }
    public function test_password_is_required()
    {
        $response = $this->submitUserData(['password' => '']);

        $this->AssertValidationError($response, 'password');
    }
    public function test_password_is_min_6_character()
    {
        $response = $this->submitUserData(['password' => 'aaaaa']);

        $this->AssertValidationError($response, 'password');
    }
    public function test_password_is_max_150_character()
    {
        $response = $this->submitUserData(['password' => Str::repeat('a', 151)]);

        $this->AssertValidationError($response, 'password');
    }
    public function test_password_is_confirmed()
    {
        $response = $this->submitUserData(['password' => 'password', 'password_confirmation' => 'notsamepassword']);

        $this->AssertValidationError($response, 'password');
    }



}
