<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

    public function testEmailUnique()
    {
        $existingUser = User::factory()->create(['email' => 'test@example.com', 'role' => 'candidat']);

        $newUser = User::factory()->make(['email' => 'test@example.com', 'role' => 'candidat']);

        $this->assertFalse($newUser->save());

        $this->assertNotNull($newUser->getError('email'));
    }

    public function testPrenomIsString()
    {
        $candidat = User::factory()->make(['prenom' => 123]);

        $this->assertFalse($candidat->save());

        $this->assertNotNull($candidat->getError('prenom'));
    }

    public function testCandidatPeutSAuthentifier()
    {

        $password = 'passer123';
        $candidat = User::factory()->create([
            'role' => 'candidat',
            'password' => Hash::make($password),
        ]);
        $response = $this->post('/api/login', [
            'email' => $candidat->email,
            'password' => $password,
        ]);
        $response->assertStatus(200);
    }

    public function testAdminLogin()
    {

        $password = 'passer123';
        $candidat = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make($password),
        ]);
        $response = $this->post('/api/login', [
            'email' => $candidat->email,
            'password' => $password,
        ]);
        $response->assertStatus(200);
    }
}

