<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use LazilyRefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_authentication_is_required(): void
    {
        $response = $this->deleteJson('api/auth/logout');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_can_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->deleteJson('api/auth/logout');
        $response->assertStatus(200)
        ->assertJson(['message' => 'Logged out successfully']);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class
        ]);
    }
}
