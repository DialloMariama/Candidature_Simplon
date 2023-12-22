<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Formation;
use App\Models\FormationUser;
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
        $response->assertJsonStructure([
            'status_code',
            'status_message',
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'formation_id',
                    'etat',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
        

    }


    public function testEnregistrementCandidature()
    {
        $candidat = User::factory()->create(['role' => 'candidat']);
        $formation = Formation::factory()->create();

        $this->actingAs($candidat, 'api');

        $response = $this->postJson('/api/storeCandidat', [
            'formation_id' => $formation->id,
        ]);

        $response->assertStatus(200);
            
    }

    public function testAccepterCandidature()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin, 'api');
        $response = $this->put('/api/AccepterCandidatures/2');
        $response->assertStatus(200);
    }

    public function testRefuserCandidature()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin, 'api');
        $response = $this->put('/api/Refusercandidatures/5');
        $response->assertStatus(200);
    }
}
