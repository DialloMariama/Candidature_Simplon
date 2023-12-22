<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormationUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testListeCandidature()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin, 'api');
        $response = $this->get('/api/candidatures');
        $response->assertStatus(200);
    }
}
