<?php

namespace Tests;

use Database\Seeders\RolesPermissionsSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesPermissionsSeeder::class);
    }

    protected function AssertValidationError(TestResponse $response, string $field)
    {
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$field]);
    }
}
