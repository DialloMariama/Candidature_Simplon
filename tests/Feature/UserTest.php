<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testListeCandidat()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin, 'api');
        $response = $this->get('/api/listeCandidat');
        $response->assertStatus(200);
    }
    
}
